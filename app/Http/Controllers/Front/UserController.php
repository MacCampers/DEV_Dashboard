<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Mail\Account\AccountActivation;

use App\User;

use Mail;
use Auth;

class UserController extends Controller {

   /**
   * Activate user account
   *
   * @return Redirect
   */
   public function activate($id, $code) {
      if( !$code ) {
         throw new InvalidConfirmationCodeException;
      }

      $user = User::where('id', $id)->whereActivationCode($code)->first();

      if( $user ) {
         $user->update([
            'confirmed' => 1,
            'activation_code' => null
         ]);

         $message = __('popups.registration.activation_success');
      } else {
         $message = __('popups.registration.activation_fail');
      }

      return redirect()->route('home')->with('popup', $message);
   }

   /**
   * Send activation link
   *
   * @return Redirect
   */
   public function sendActivationLink(Request $request) {
      $user = Auth::user();

      if( !$user->activation_code ) {
         $user->update(['activation_code' => str_random(30)]);
      }

      Mail::to($user)->send(new AccountActivation($user));

      return redirect()->back()->with('popup', __('popups.registration.activation_resent'));
   }

   /**
   * Get user by email
   *
   * @return Response
   */
   public function getByEmail(Request $request, $type = null) {
      $this->validate($request, [
         'email' => 'email|required',
      ]);

      $user = User::with('company')->where('email', $request->input('email'))->first();

      // Check user type
      if( $type && $user && $user->type !== $type ) {
         return response()->json([
            'errors' => [
               'email' => [
                  trans('validation.custom.user_type.exists')
               ]
            ]
         ], 422);
      }

      return response()->json(['user' => $user]);
   }

}
