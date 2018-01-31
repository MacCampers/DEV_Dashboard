<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Company;
use App\Match;
use App\User;
use App\Strategy;

use Auth;

class DashboardController extends Controller {

   /**
   * Show dashboard home
   *
   * @return View
   */
   public function index() {
      $user = Auth::user()->load('projects');

      $data = [
         'user' => $user
      ];

      if( $user->type === 'investor' ) {
         $matches = collect();

         foreach( $user->strategies as $strategy ) {
            $matches = $matches->merge($strategy->matches);
         }

         $matches = $matches->merge($user->matches);

         $data['matches'] = $matches;
      } else {
         $data['projects'] = $user->projects->merge($user->invitations);
      }

      return view('front.dashboard.home.' . $user->type, $data);
   }

   /**
   * Show dashboard home
   *
   * @return View
   */
   public function faq() {
      return view('front.dashboard.help.faq');
   }
}
