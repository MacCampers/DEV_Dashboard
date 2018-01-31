<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Mail\Match\NewNdaVersion;
use App\Mail\Match\BypassedNdaNotification;

use App\Project;
use App\Match;
use App\MatchEvent;
use App\Document;

use Auth;
use PDF;
use Storage;
use Mail;

class NdaController extends Controller {

   /**
   * View NDA
   *
   * @return View
   */
   public function view($matchId) {
      $match = Match::with(['nda', 'project'])->find($matchId);

      if( !$match ) {
         abort(404);
      }

      $data = [
         'match' => $match,
         'project' => $match->project,
         'isEditable' => Auth::user()->canEditNda($match),
      ];

      return view('front.dashboard.match.nda.view', $data);
   }

   /**
   * Edit NDA
   *
   * @return View|Redirect
   */
   public function edit($matchId) {
      $match = Match::find($matchId);

      if( !$match ) {
         abort(404);
      }

      if( !Auth::user()->canEditNda($match) ) {
         return redirect()->route('match_view_nda', $match);
      }

      $data = [
         'match' => $match,
         'project' => $match->project,
      ];

      return view('front.dashboard.match.nda.edit', $data);
   }

   /**
   * Update NDA
   *
   * @return Redirect
   */
   public function update(Request $request, $matchId) {
      $match = Match::find($matchId);

      $this->validate($request, [
         'nda' => 'required',
      ]);

      $data = ['nda_text' => $request->input('nda')];

      if( Auth::user()->type === 'investor' ) {
         $data['nda_accepted_strategy'] = 1;
         $data['nda_accepted_company'] = 0;

         $successMessage = trans('popups.nda.edit_investor_success');

         Mail::to($match->project->users)->send(new NewNdaVersion($match, 'strategy'));
      } else {
         $data['nda_accepted_company'] = 1;
         $data['nda_accepted_strategy'] = 0;

         $successMessage = trans('popups.nda.edit_contractor_success');

         Mail::to($match->getParticipants())->send(new NewNdaVersion($match, 'project'));
      }

      $match->update($data);

      // Create event
      MatchEvent::create([
         'match_id' => $matchId,
         'description' => 'nda_edited'
      ]);

      return redirect()->route('match_overview', ['id' => $matchId])->with('popup', $successMessage);
   }

   /**
   * Cancel NDA
   *
   * @return Redirect
   */
   public function cancel($matchId) {
      $match = Match::find($matchId);

      if( !$match ) {
         abort(404);
      }

      // Delete NDA and update status
      $match->nda->delete();
      $match->update([
         'nda_accepted_company' => 0
      ]);

      // Delete signatories
      $match->nda->signatories->delete();

      // Create event
      MatchEvent::create([
         'match_id' => $matchId,
         'description' => 'nda_cancelled'
      ]);

      return redirect()->route('match_view_nda', ['id' => $matchId]);
   }


   /**
   * Accept NDA
   *
   * @return Redirect
   */
   public function accept($matchId) {
      $match = Match::find($matchId);

      if( !$match ) {
         abort(404);
      }

      /*
      |--------------------------------------------------------------------------
      | Generate PDF
      |--------------------------------------------------------------------------
      */

      $pdf = PDF::loadView('front.dashboard.match.nda.pdf', ['content' => $match->nda_text])->setPaper('a4')->setOption('margin-bottom', 30);
      $fileName = 'nda.pdf';
      $uri = $match->project_id . '/' . $match->id . '/' . $fileName;

      // Save file
      Storage::put($uri, $pdf->output());

      $size = Storage::size($uri);

      // Save document
      $document = Document::create([
         'project_id' => $match->project_id,
         'name' => $fileName,
         'uri' => $uri,
         'size' => $size,
         'section' => 'nda'
      ]);

      // Init signatories
      $users = collect();

      // Investor
      $users->push($match->strategy_signatory);

      // Contractor
      if( $match->project->signatory_id ) {
         $users->push($match->project->signatory);
      } else {
         $users->push($match->project->representative);
      }

      $options = [
         [
            'page' => '1',
            'position' => '485,11,583,51',
         ], [
            'page' => '1',
            'position' => '376,11,475,51',
         ]
      ];

      // Init signature
      if( $document->initSignature($users, $options) ) {
         // Update match state
         $data['nda_id'] = $document->id;

         if( Auth::user()->type === 'investor' ) {
            $data['nda_accepted_strategy'] = 1;
         } else {
            $data['nda_accepted_company'] = 1;
         }

         $match->update($data);

         // Create event
         MatchEvent::create([
            'match_id' => $matchId,
            'description' => 'nda_accepted'
         ]);

         return redirect()->route('match_overview', ['id' => $matchId])->with('popup', trans('popups.nda.accepted'));
      }

      return redirect()->back()->with('popup', trans('popups.nda.error'));
   }


   // Accept NDA without signature
   public function bypass($matchId) {
      $match = Match::find($matchId);

      $match->update([
         'nda_accepted_company' => 1,
         'nda_bypass' => 1,
      ]);

      // Create event
      MatchEvent::create([
         'match_id' => $matchId,
         'description' => 'nda_bypassed',
      ]);

      // Send email
      Mail::to($match->getParticipants())->send(new BypassedNdaNotification($match));

      return redirect()->route('match_overview', ['id' => $matchId])->with('popup', trans('popups.nda.bypassed'));
   }

}
