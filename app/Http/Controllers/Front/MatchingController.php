<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\AlgorithmController;

use App\Project;
use App\Strategy;
use App\Match;
use App\User;
use App\Company;

class MatchingController extends AlgorithmController {

   /**
   * Make match between the project and the investors
   *
   * @return View
   */
   public function search($id) {
      $project = Project::with(['activity_areas'])->find($id);


      // Abort if project has already started
      if( $project->getOriginal('start_date') || !$project->confirmed ) {
         abort(403);
      }

      // Delete previous matches
      Match::where('project_id', $project->id)->delete();

      $results = $this->run($project);

      /*
      |--------------------------------------------------------------------------
      | Create matches
      |--------------------------------------------------------------------------
      */

      $index = 0;
      $previousScore = 0;

      foreach( $results as $strategy ) {
         $index++;

         if( $index > 40 && $strategy->score < $previousScore ) {
            break;
         }

         Match::create([
            'project_id' => $project->id,
            'matchable_id' => $strategy->id,
            'matchable_type' => 'strategy',
            'score' => $strategy->score,
         ]);

         $previousScore = $strategy->score;
      }

      return view('front.dashboard.project.matching.results')->with(['project' => $project, 'strategies' => $results]);
   }


   /**
   * Show matching results and lock project
   *
   * @return View
   */
   public function showResults(Request $request, $id) {
      $project = Project::with(['matches.matchable', 'matches.matchable.company'])->find($id);

      // Abort if project has not started
      if( !$project->getOriginal('start_date') ) {
         abort(403);
      }

      $matches = $project->matches->pluck('id');

      return view('front.dashboard.project.matching.selection')->with(['project' => $project, 'matches' => $matches]);
   }


   /**
   * Create new investor
   *
   * @return Redirect
   */
   public function addInvestor(Request $request, $id) {
      $project = Project::find($id);

      if( $request->has('contact_id') ) {
         $this->validate($request, [
            'contact_id' => 'exists:users,id|required',
         ]);

         $user = User::find($request->input('contact_id'));

         if( $user->type !== 'investor' ) {
            return redirect()->back()->with('popup', trans('popups.add_investor.type_error'));
         } elseif( $project->matches->where('matchable_type', 'user')->where('matchable_id', $user->id)->count() > 0 ) {
            return redirect()->back()->with('popup', trans('popups.add_investor.exists_error'));
         }
      } else {
         $this->validate($request, [
            'company_name' => 'max:191|required',
            'company_registration_number' => 'max:50|nullable',
            'contact_first_name' => 'max:60|required',
            'contact_last_name' => 'max:60|required',
            'contact_email' => 'email|unique:users,email|required',
            'contact_phone' => 'max:25|nullable',
         ]);

         $company = Company::create([
            'name' => $request->input('company_name'),
            'type' => 'investment',
            'registration_number' => $request->input('company_registration_number'),
            'category' => $request->input('company_category'),
         ]);

         $user = User::create([
            'type' => 'investor',
            'first_name' => $request->input('contact_first_name'),
            'last_name' => $request->input('contact_last_name'),
            'email' => $request->input('contact_email'),
            'phone_mobile' => $request->input('contact_phone'),
            'company_id' => $company->id,
            'company_role' => 'representative',
            'confirmed' => 1,
         ]);
      }

      $match = Match::create([
         'project_id' => $id,
         'matchable_id' => $user->id,
         'matchable_type' => 'user',
         'score' => 0,
         'strategy_signatory_id' => $user->id,
      ]);

      $selectedMatches = $request->input('selected_matches');
      $selectedMatches[] = $match->id;

      return redirect()->route('project_matching_results', ['id' => $id])->with('selected_matches', $selectedMatches);
   }

   /**
   * Store selection and send notifications
   *
   * @return Redirect
   */
   public function storeSelection(Request $request, $id) {
      if( !$request->has('matches') ) {
         return redirect()->back()->with('selection_error', true);
      }

      $project = Project::find($id);
      $matches = Match::with(['matchable', 'matchable.company'])->whereIn('id', $request->input('matches'))->get();

      $project->start_date = date('Y-m-d H:i:s');
      $project->save();

      foreach( $matches as $match ) {
         $update = ['selected' => 1];

         if( $project->need_nda ) {
            $update['nda_text'] = $project->getField('nda');
         } else {
            $update['nda_accepted_company'] = 1;
            $update['nda_accepted_strategy'] = 1;
         }

         $match->update($update);

         foreach( $match->getParticipants() as $user ) {
            $user->sendMatchNotification($match);
         }
      }

      return redirect()->route('project_overview', $id)->with('popup', trans('popups.match.mail_sent'));
   }

}
