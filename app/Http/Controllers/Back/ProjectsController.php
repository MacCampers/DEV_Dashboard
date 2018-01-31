<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\AlgorithmController;

use App\Mail\Project\ProjectValidation;
use App\Mail\Project\ProjectRefusal;
use App\Mail\Project\ProjectStopped;
use App\Mail\Project\ProjectCancelled;

use App\Project;

use Mail;

class ProjectsController extends AlgorithmController {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show projects list
   *
   * @return View
   */
   public function index(Request $request) {
      if( $request->input('s') !== null && $request->input('s') !== '' ) {
         $search = '%'.$request->input('s').'%';

         $projects = Project::with('company')->where('code_name', 'like', $search)->sortable(['created_at' => 'desc'])->paginate(100);
      } else {
         $projects = Project::with('company')->sortable(['created_at' => 'desc'])->paginate(100);
      }

      return view('back.projects.index')->with(['projects' => $projects]);
   }

   /**
   * Edit project
   *
   * @return View
   */
   public function edit($id) {
      $project = Project::find($id);

      return view('back.projects.edit')->with(['project' => $project]);
   }

   /**
   * View project
   *
   * @return View
   */
   public function view($id, $step = 'synthesis') {
      $project = Project::find($id);

      return view('back.projects.view', ['project' => $project, 'step' => $step]);
   }

   /**
   * View match results
   *
   * @return View
   */
   public function runAlgorithm($id) {
      $project = Project::find($id);

      $results = $this->run($project, true);

      return view('back.projects.logs', ['project' => $project, 'strategies' => $results['strategies'], 'logs' => $results['logs']]);
   }

   /**
   * Confirm project
   *
   * @return Redirect
   */
   public function confirm($id) {
      $project = Project::find($id);

      $project->confirmed = true;
      $project->save();

      Mail::to($project->admins)->send(new ProjectValidation($project));

      return redirect()->back()->with('success_message', "Le projet a été validé et un email a été envoyé aux gestionnaires.");
   }

   /**
   * Decline project
   *
   * @return Redirect
   */
   public function decline(Request $request, $id) {
      $project = Project::find($id);

      $project->update([
         'confirmed' => false,
         'locked' => false,
         'comment_equiteasy' => $request->input('comment'),
      ]);

      Mail::to($project->admins)->send(new ProjectRefusal($project));

      return redirect()->back()->with('success_message', "Le projet a été refusé et un email a été envoyé aux gestionnaires.");
   }

   /**
   * Cancel project
   *
   * @return Redirect
   */
   public function cancel(Request $request, $id) {
      $project = Project::find($id);

      $project->update([
         'canceled' => true,
         'comment_equiteasy' => $request->input('comment'),
      ]);

      // Send an email to the project managers
      if( $project->users->count() > 0 ) {
         Mail::to($project->users)->send(new ProjectStopped($project));
      }

      // Send an email to the participants
      foreach( $project->selected_matches as $match ) {
         $participants = $match->getParticipants();
         if( $participants->count() > 0 ) {
            Mail::to($participants)->send(new ProjectCancelled($project));
         }
      }

      return redirect()->back()->with('success_message', "Le projet a été arrêté et tous les participants ont été prévenus par email.");
   }

   /**
   * Download project
   *
   * @return Response
   */
   public function download($id) {
      $project = Project::find($id);

      // Download zip
      return $project->download();
   }

}
