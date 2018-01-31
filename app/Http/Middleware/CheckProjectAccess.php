<?php

namespace App\Http\Middleware;

use App\Project;

use Closure;
use Auth;

class CheckProjectAccess {
   /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
   public function handle($request, Closure $next, $access = null) {
      $user = Auth::user();

      // If we have a project id, check if the user has access to it
      if( $request->id ) {
         $project = Project::find($request->id);

         if( !$project ) {
            abort(404);
         }

         if( !$project->initiator->company->isSubscribed() ) {
            abort(403);
         }

         if( !$project->canceled ) {
            // Get user access to the project
            $projectRole = $user->getProjectAccess($project);

            // Share project role with views
            view()->share('projectRole', $projectRole);

            // If an admin access is specified, check the user's role
            if( $access === 'admin' ) {
               if( $projectRole === 'admin' || $projectRole === 'representative' ) {
                  return $next($request);
               }
            }
            // Otherwise check if the user has a specified role
            elseif( $projectRole ) {
               return $next($request);
            }
         }
      }
      // If we don't, check if the user is a project manager
      elseif( $user->isProjectManager() ) {
         return $next($request);
      }

      abort(403);
   }
}
