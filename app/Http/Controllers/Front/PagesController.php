<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\ContactEmail;

use Mail;

class PagesController extends Controller {

   /**
   * Show contact page
   *
   * @return View
   */
   public function contact() {
      return view('front.pages.contact');
   }

   /**
   * Show team page
   *
   * @return View
   */
   public function team() {
      return view('front.pages.team');
   }

   /**
   * Show legal page
   *
   * @return View
   */
   public function legal() {
      return view('front.pages.legal');
   }

   /**
   * Show concept page
   *
   * @return View
   */
   public function concept() {
      return view('front.pages.concept');
   }

   /**
   * Show prices page
   *
   * @return View
   */
   public function prices() {
      return view('front.pages.prices');
   }

   /**
   * Show help page
   *
   * @return View
   */
   public function help() {
      return view('front.pages.help');
   }

   /**
   * Show terms page
   *
   * @return View
   */
   public function terms() {
      return view('front.pages.terms');
   }

   /**
   * Show document page
   *
   * @return View
   */
   public function document() {
      return view('front.pages.documents');
   }


   /**
   * Show profile page
   *
   * @return View
   */
   public function profile($slug) {
      $profiles = [
         'entrepreneur' => 'contractor',
         'conseiller' => 'advisor',
         'investisseur' => 'investor',
         'repreneur' => 'manager',
      ];

      if( !array_key_exists($slug, $profiles) ) {
         abort(404);
      }

      return view('front.pages.profiles.' . $profiles[$slug]);
   }

   /**
   * Send email via contact page
   *
   * @return Redirect
   */
   public function sendContactEmail(Request $request) {
      $this->validate($request, [
         'name' => 'required',
         'email' => 'email|required',
         'subject' => 'required',
         'message' => 'required',
         'g-recaptcha-response' => 'required',
      ]);

      Mail::to(env('SUPPORT_EMAIL'))->send(new ContactEmail($request->input('name'), $request->input('email'), $request->input('subject'), $request->input('message')));

      return redirect()->back()->with('popup', __('popups.contact.success'));
   }

}
