<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\User;
use App\Match;

use Validator;
use Hash;
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
   * Create a new controller instance.
   *
   * @return void
   */
   public function __construct() {
      $this->middleware('guest')->except('logout');
   }

   /**
   * Show login form
   *
   * @return View
   */
   public function index(Request $request) {
      return view('front.auth.login.index');
   }

   /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
   */
   public function login(Request $request) {
      $validator = Validator::make($request->all(), [
         $this->username() => 'required|email',
         'password' => 'required|string'
      ]);

      if( $validator->fails() ) {
         return redirect()->back()
            ->with('login_error', true)
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($validator);
      }

      // If the class is using the ThrottlesLogins trait, we can automatically throttle
      // the login attempts for this application. We'll key this by the username and
      // the IP address of the client making these requests into this application.
      if( $this->hasTooManyLoginAttempts($request) ) {
         $this->fireLockoutEvent($request);

         return $this->sendLockoutResponse($request);
      }

      if( $this->attemptLogin($request) ) {
         return $this->sendLoginResponse($request);
      }

      // If the login attempt was unsuccessful we will increment the number of attempts
      // to login and redirect the user back to the login form. Of course, when this
      // user surpasses their maximum number of attempts they will get locked out.
      $this->incrementLoginAttempts($request);

      return $this->sendFailedLoginResponse($request);
   }

   /**
   * Get the failed login response instance.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
   protected function sendFailedLoginResponse(Request $request) {
      $errors = [$this->username() => trans('auth.failed')];

      if( $request->expectsJson() ) {
         return response()->json($errors, 422);
      }

      return redirect()->back()
         ->with('login_error', true)
         ->withInput($request->only($this->username(), 'remember'))
         ->withErrors($errors);
   }

   /**
   * Redirection after success login
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return \Illuminate\Http\RedirectResponse
   */
   protected function authenticated(Request $request, $user) {
      if( $request->has('match_id') ) {
         $match = Match::find($request->input('match_id'));

         if( $match ) {
            $match->update(['accepted' => 1]);
         }
      }

      if( $request->has('redirect_to') ) {
         return redirect($request->input('redirect_to'));
      }
      return redirect()->intended('projects');
   }

   public function createPassword(Request $request) {
      $validator = Validator::make($request->all(), [
         'password' => 'required|between:8,30|confirmed'
      ]);

      if( $validator->fails() ) {
         return redirect()->back()
            ->with('password_error', true)
            ->withErrors($validator);
      }

      // Retrieve user with email and token
      $user = User::where('email', $request->input('email'))->where('password_creation_token', $request->input('token'))->first();

      if( !$user ) {
         return redirect()->back()->with([
            'password_error' => true,
            'error_message' => trans('validation.custom.token_error')
         ]);
      }

      // Save password
      $user->update([
         'password_creation_token' => null,
         'password' => Hash::make($request->input('password'))
      ]);

      // Authenticate user
      Auth::login($user);

      if( $request->has('match_id') ) {
         $match = Match::find($request->input('match_id'));

         if( $match ) {
            $match->update(['accepted' => 1]);
         }
      }

      // Redirect to dashboard
      if( $request->has('redirect_to') ) {
         return redirect($request->input('redirect_to'));
      }

      return redirect()->route('projects');
   }
}
