<?php

namespace App\Http\Middleware;

use App\Match;

use Closure;
use Auth;

class CheckMatchAccess {
   /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
   public function handle($request, Closure $next, $access = null) {
      $user = Auth::user();

      // If we have a match id, check if the user has access to it
      if( $request->id ) {
         $match = Match::find($request->id);

         if( !$match ) {
            abort(404);
         }

         // Get user access
         $matchAccess = $user->getMatchAccess($match);
         $projectRole = $matchAccess === 'project' ? $user->getProjectAccess($match->project) : null;

         // Share access rights with views
         view()->share('matchAccess', $matchAccess);
         view()->share('projectRole', $projectRole);

         // Check if user has an access right
         if( $matchAccess ) {
            if( $access === 'strategy' && $matchAccess !== 'strategy' ) {
               abort(403);
            }
            return $next($request);
         }

         // If an admin access is specified, check the user's role in the project
         if( $access === 'admin' && ($projectRole === 'admin' || $projectRole === 'representative')) {
            return $next($request);
         }

         abort(403);
      }

      abort(404);
   }
}
