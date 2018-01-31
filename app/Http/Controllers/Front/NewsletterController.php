<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sendinblue\Mailin;

use App\Mail\NewsletterWelcome;

use Mail;

class NewsletterController extends Controller {

   /**
   * Subscribe email to the newsletter
   *
   * @return Redirect
   */
   public function subscribe(Request $request) {
      $mailin = new Mailin(env('SENDINBLUE_URL'), env('SENDINBLUE_KEY'));

      $this->validate($request, [
         'email' => 'email|required',
      ]);

      $data = [
         'email' => $request->input('email'),
         'listid' => [12],
      ];

      Mail::to($request->input('email'))->send(new NewsletterWelcome());

      if( $mailin->create_update_user($data) ) {
         return redirect()->back()->with('popup', trans('common.newsletter.success'));
      }

      return redirect()->back()->with('popup', trans('common.newsletter.error'));
   }

}
