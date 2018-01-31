<?php

namespace App\Http\Controllers\Back\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Auth;

class LoginController extends Controller {
   /*
   |--------------------------------------------------------------------------
   | Login Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles authenticating users for the application and
   | redirecting them to your home screen. The controller uses a trait
   | to conveniently provide its functionality to your applications.
   |
   */

   use AuthenticatesUsers;

   /**
   * Where to redirect users after login.
   *
   * @var string
   */
   protected function redirectTo() {
      if( Auth::guard('admin')->user()->role === 'cdd' ) {
         return '/admin/companies/create';
      } else {
         return '/admin';
      }
   }

   protected function guard() {
      return Auth::guard('admin');
   }

   public function showLoginForm(Request $request) {
      return view('back.auth.login');
   }

   protected function authenticated(Request $request, $user) {
      $user->last_connection = date('Y-m-d H:i:s');
      $user->save();
   }
}
