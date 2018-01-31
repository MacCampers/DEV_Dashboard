<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Mail\Match\DeclinedMatchNotification;
use App\Mail\Match\NewDocumentNotification;
use App\Mail\Match\DeclinedDocumentNotification;
use App\Mail\Match\AcceptedDocumentNotification;
use App\Mail\Match\MatchStoppedNotification;
use App\Mail\Match\NewMessageNotification;

use App\Match;
use App\MatchEvent;
use App\User;
use App\Message;
use App\LoiRequirement;

use Auth;
use Storage;
use Mail;

class MatchesController extends Controller {

   /**
   * Show overview
   *
   * @return View
   */
   public function overview($id) {
      $match = Match::with(['events', 'project'])->find($id);

      if( !$match ) {
         abort(404);
      }

      $access = Auth::user()->getMatchAccess($match);

      $data = [
         'match' => $match,
         'project' => $match->project,
         'access' => $access,
         'with' => $access === 'project' ? $match->matchable->full_name : $match->project->company_name,
      ];

      return view('front.dashboard.match.'. $access .'.overview', $data);
   }

   /**
   * View discussion
   *
   * @return View
   */
   public function discussion($id) {
      $match = Match::with('messages')->find($id);
      $messages = $match->messages->concat($match->events)->sortBy('created_at');

      return view('front.dashboard.match.discussion', ['match' => $match, 'project' => $match->project, 'messages' => $messages]);
   }

   /**
   * View project
   *
   * @return View
   */
   public function project($id, $step) {
      $match = Match::find($id);

      if( Auth::user()->type === 'investor' && !($match->hasSignedNda() || $match->isViewable()) ) {
         abort(403);
      }

      return view('front.dashboard.match.strategy.project', ['match' => $match, 'project' => $match->project, 'step' => $step]);
   }

   /**
   * Send message
   *
   * @return Redirect
   */
   public function sendMessage(Request $request, $id) {
      $match = Match::find($id);

      $this->validate($request, [
         'message' => 'required_without:attachments',
         'attachments' => 'required_without:message',
      ]);

      $sender = Auth::user()->getMatchAccess($match);

      $message = Message::create([
         'match_id' => $id,
         'sender' => $sender,
         'user_id' => Auth::id(),
         'content' => $request->input('message')
      ]);

      if( $request->has('attachments') ) {
         $message->uploadAttachments($request->file('attachments'));
      }

      // Send notification
      if( $match->accepted ) {
         if( $sender === 'project' ) {
            $users = $match->getParticipants();
            $sender = $match->project->code_name;
         } else {
            $users = $match->project->admins;
            $sender = $match->matchable->full_name;
         }

         $message = substr($request->input('message'), 0, 150);

         Mail::to($users)->send(new NewMessageNotification($match, $message, $sender));
      }

      return redirect()->back();
   }

   /**
   * Show teaser to an investor via link received by mail
   *
   * @return View
   */
   public function showTeaser(Request $request, $id) {
      $match = Match::with('project')->find($id);

      if( !$match ) {
         abort(404);
      }

      $now = Carbon::today();
      $endDate = $match->project->end_date->subWeeks(2);

      if( $now->gt($endDate) || $match->project->stopped ) {
         $projectPast = 1;
      } else {
         $projectPast = 0;
      }

      if( !$match->accepted ) {
         Auth::logout();

         $user = User::where('email', $request->input('email'))->first();
      } else {
         $user = null;
      }

      $match->update([
         'viewed' => 1,
         'declined' => 0,
      ]);

      $teaser = $match->project->getField('teaser_welcome');
      $redirectRoute = route('match_overview', ['id' => $id]);

      return view('front.teaser.index')->with(['teaser' => $teaser, 'user' => $user, 'redirectRoute' => $redirectRoute, 'match' => $match, 'projectPast' => $projectPast]);
   }

   /**
   * Update signatory
   *
   * @return Redirect
   */
   public function updateSignatory(Request $request, $id) {
      $this->validate($request, [
         'signatory_id' => 'exists:users,id'
      ]);

      if( !$request->has('signatory_id') ) {
         return redirect()->back();
      }

      // Get user
      $user = User::find($request->input('signatory_id'));

      // Update mobile phone number if necessary
      if( !$user->phone_mobile ) {
         $this->validate($request, [
            'signatory_phone_number' => 'max:25|required'
         ]);

         $user->update([
            'phone_mobile' => $request->input('signatory_phone_number')
         ]);
      }

      // Update match
      $match = Match::find($id);
      $match->update([
         'strategy_signatory_id' => $request->input('signatory_id')
      ]);

      return redirect()->back()->with('popup', trans('popups.update_signatory.success'));
   }

   /**
   * View document
   *
   * @return View
   */
   public function viewDocument($id, $type) {
      if( $type !== 'loi' && $type !== 'binding_offer' ) {
         abort(404);
      }

      $match = Match::find($id);
      $offers = $match->getOffersHistory($type);
      $currentOffer = $match->getCurrentOffer($type);

      return view('front.dashboard.match.document.view')->with(['match' => $match, 'project' => $match->project, 'type' => $type, 'currentOffer' => $currentOffer, 'offers' => $offers]);
   }

   /**
   * Show document upload form
   *
   * @return View|Redirect
   */
   public function showUploadForm($id, $type) {
      if( $type !== 'loi' && $type !== 'binding_offer' ) {
         abort(404);
      }

      $match = Match::find($id);
      $loiRequirements = LoiRequirement::all()->where('parent', null);

      $acceptedAttr = $type . '_accepted';
      if( $match->$acceptedAttr ) {
         return redirect()->route('match_view_document', ['id' => $id, 'type' => $type]);
      }

      $currentOffer = $match->getCurrentOffer($type);
      $offers = $match->getOffersHistory($type);

      return view('front.dashboard.match.document.upload')->with(['match' => $match, 'project' => $match->project, 'type' => $type, 'currentOffer' => $currentOffer, 'offers' => $offers, 'loiRequirements' => $loiRequirements]);
   }

   /**
   * Upload document
   *
   * @return Redirect
   */
   public function uploadDocument(Request $request, $id, $type) {
      if( $type !== 'loi' && $type !== 'binding_offer' ) {
         abort(404);
      }

      $match = Match::find($id);

      $this->validate($request, [
         'document' => 'mimes:pdf'
      ]);

      $acceptedAttr = $type . '_accepted';
      if( $match->$acceptedAttr ) {
         return redirect()->route('match_view_document', ['id' => $id, 'type' => $type]);
      }

      $document = $match->uploadOffer($request->file('document'), $type, $request->input('comment'));

      if( $document ) {
         // Create event
         MatchEvent::create([
            'match_id' => $id,
            'description' => $type . '_uploaded'
         ]);

         // Send notification
         $users = $match->project->users;
         Mail::to($users)->send(new NewDocumentNotification($match, $type));

         return redirect()->route('match_overview', ['id' => $id])->with('popup', trans('popups.'. $type .'.upload_success'));
      }

      return redirect()->back()->withErrors(['document' => trans('dashboard.upload_' . $type . '.error')]);
   }

   /**
   * Accept document
   *
   * @return Redirect
   */
   public function acceptDocument(Request $request, $id, $type) {
      if( $type !== 'loi' && $type !== 'binding_offer' ) {
         abort(404);
      }

      // @TODO: ne pas pouvoir accepter si un nouveau document a été uploadé

      $match = Match::find($id);

      $offer = $match->getCurrentOffer($type);
      $offer->update(['recipient_comment' => $request->input('comment')]);
      $match->update([$type . '_accepted' => 1]);

      // Create event
      MatchEvent::create([
         'match_id' => $id,
         'description' => $type . '_accepted'
      ]);

      // Send notification
      Mail::to($match->getParticipants())->send(new AcceptedDocumentNotification($match, $offer));

      return redirect()->route('match_overview', ['id' => $id])->with('popup', trans('popups.'. $type .'.accepted'));
   }

   /**
   * Decline document
   *
   * @return Redirect
   */
   public function declineDocument(Request $request, $id, $type) {
      if( $type !== 'loi' && $type !== 'binding_offer' ) {
         abort(404);
      }

      $match = Match::find($id);

      // Update offer status
      $offer = $match->getCurrentOffer($type);
      $offer->update([
         'declined' => 1,
         'recipient_comment' => $request->input('comment'),
      ]);

      // Create event
      MatchEvent::create([
         'match_id' => $id,
         'description' => $type . '_declined'
      ]);

      // Send notification
      Mail::to($match->getParticipants())->send(new DeclinedDocumentNotification($match, $offer));

      return redirect()->route('match_overview', ['id' => $id])->with('popup', trans('popups.'. $type .'.declined'));
   }

   /**
   * Decline match (for investors receiving the email)
   *
   * @return Redirect
   */
   public function decline($id) {
      $match = Match::find($id);

      if( !$match ) {
         abort(404);
      }

      $match->update([
         'accepted' => 0,
         'declined' => 1
      ]);

      // Create event
      MatchEvent::create([
         'match_id' => $id,
         'description' => 'teaser_declined'
      ]);

      $users = $match->project->users;
      Mail::to($users)->send(new DeclinedMatchNotification($match));

      return redirect()->route('home')->with('popup', trans('popups.teaser_decline.confirmation'));
   }

   /**
   * Decline match (for investors receiving the email)
   *
   * @return Redirect
   */
   public function declineTeaser(Request $request, $id) {
      $match = Match::find($id);

      if( !$match ) {
         abort(404);
      }

      $this->validate($request, [
         'end_comment' => 'max:2000|nullable',
      ]);

      $match->update([
         'accepted' => 0,
         'declined' => 1,
         'end_comment' => $request->input('end_comment'),
      ]);

      // Create event
      MatchEvent::create([
         'match_id' => $id,
         'description' => 'teaser_declined'
      ]);

      $users = $match->project->users;
      Mail::to($users)->send(new DeclinedMatchNotification($match));

      return redirect()->route('home')->with('popup', trans('popups.teaser_decline.confirmation'));
   }

   /**
   * Resend matching email
   *
   * @return Redirect
   */
   public function sendMatchingMail(Request $request, $id) {
      $match = Match::find($id);

      foreach( $match->getParticipants() as $user ) {
         $user->sendMatchNotification($match);
      }

      return redirect()->back()->with('popup', trans('dashboard.matching.email_sent'));
   }

   /**
   * Stop match
   *
   * @return Redirect
   */
   public function stop(Request $request, $id) {
      $match = Match::find($id);

      $access = Auth::user()->getMatchAccess($match);

      if( !$access ) {
         abort(403);
      }

      $match->update([
         'ended_at' => Carbon::now(),
         'ended_by' => $access,
         'end_comment' => $request->input('end_comment'),
      ]);

      // Create event
      MatchEvent::create([
         'match_id' => $id,
         'description' => 'match_ended',
         'initiator' => $access,
      ]);

      // Generate zip
      $match->generate();

      // Send an email to the participants
      if( $access === 'strategy' ) {
         Mail::to($match->project->users)->send(new MatchStoppedNotification($match));

         return redirect()->route('match_overview', ['id' => $id])->with('popup', trans('popups.match.stopped_strategy'));
      } else {
         Mail::to($match->getParticipants())->send(new MatchStoppedNotification($match));

         return redirect()->route('match_overview', ['id' => $id])->with('popup', trans('popups.match.stopped_project', ['strategy' => $match->matchable->full_name]));
      }
   }

   /**
   * Download project
   *
   * @return Redirect
   */
   public function download($id) {
      $match = Match::find($id);

      // Download pdf
      return $match->download();
   }

}
