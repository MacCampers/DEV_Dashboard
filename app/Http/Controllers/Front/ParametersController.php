<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use App\Http\Controllers\Controller;

use Laravel\Cashier\Subscription;
use Carbon\Carbon;

use App\Company;
use App\User;
use App\Zone;
use App\Invoice;

use Auth;
use Hash;
use PDF;
use Mail;
use Validator;

class ParametersController extends Controller {

   /**
   * Show personal information
   *
   * @return View
   */
   public function personal() {
      $user = Auth::user();
      $zones = Zone::all();
      $countries = $zones->where('type', 'country');
      $regions = $zones->where('type', 'region');

      $data = [
         'user' => $user,
         'countries' => $countries,
         'regions' => $regions,
      ];

      return view('front.dashboard.parameters.personal', $data);
   }

   /**
   * Show company information
   *
   * @return View
   */
   public function company() {
      $user = Auth::user();
      $zones = Zone::all();
      $countries = $zones->where('type', 'country');
      $regions = $zones->where('type', 'region');

      if( $user->company_role !== 'admin' && $user->company_role !== 'representative' ) {
         abort(403);
      }

      $data = [
         'user' => $user,
         'countries' => $countries,
         'regions' => $regions,
         'company' => $user->company,
      ];

      return view('front.dashboard.parameters.company', $data);
   }

   /**
   * Show subscription
   *
   * @return View
   */
   public function subscription() {
      $user = Auth::user();
      $zones = Zone::all();
      $subscription = $user->subscription($user->type);

      if( !$subscription ) {
         abort(403);
      }

      $data = [
         'user' => $user,
         'subscription' => $subscription,
         'stripePlan' => $subscription->asStripeSubscription()->plan,
         'countries' => $zones->where('type', 'country'),
      ];

      return view('front.dashboard.parameters.subscription', $data);
   }

   /**
   * Show users
   *
   * @return View
   */
   public function users() {
      $user = Auth::user();

      if( $user->company_role !== 'representative' || $user->type === 'contractor' ) {
         abort(403);
      }

      $data = [
         'user' => $user,
         'associates' => $user->company->users->where('company_role', 'admin'),
      ];

      return view('front.dashboard.parameters.users', $data);
   }

   /**
   * Update personal information
   *
   * @return Redirect
   */
   public function updatePersonalInfo(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
         'user_first_name' => 'max:60|required',
         'user_last_name' => 'max:60|required',
         'user_job' => 'max:60',
         'user_birth_date' => 'date_format:d/m/Y|nullable',
         'user_phone_mobile' => 'nullable|max:25',
         'user_phone_fixed' => 'nullable|max:25',
         'user_linkedin_url' => 'url|nullable',
         'user_viadeo_url' => 'url|nullable',
      ]);

      $user->update([
         'first_name' => $request->input('user_first_name'),
         'last_name' => $request->input('user_last_name'),
         'job' => $request->input('user_job'),
         'birth_date' => $request->input('user_birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('user_birth_date')) : null,
         'phone_mobile' => $request->input('user_phone_mobile'),
         'phone_fixed' => $request->input('user_phone_fixed'),
         'linkedin_url' => $request->input('user_linkedin_url'),
         'viadeo_url' => $request->input('user_viadeo_url'),
      ]);

      return redirect()->back()->with('success_message', trans('parameters.personal.update_information_success'));
   }

   /**
   * Update email
   *
   * @return Redirect
   */
   public function updateEmail(Request $request) {
      $user = Auth::user();

      $validation = Validator::make($request->all(), [
         'user_email' => 'email|required',
      ]);

      $exists = User::where('email', $request->input('user_email'))->where('id', '!=', $user->id)->count();

      if( $exists ) {
         return redirect()->back()->withInput()->withErrors(['user_email' => trans('validation.custom.email.exists')]);
      }

      $user->email = $request->input('user_email');
      $user->save();

      return redirect()->back()->with('success_message', trans('parameters.personal.update_email_success'));
   }

   /**
   * Update password
   *
   * @return Redirect
   */
   public function updatePassword(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
         'new_password' => 'different:current_password|between:8,30|confirmed',
      ]);

      if( !Hash::check($request->input('current_password'), $user->password) ) {
         return redirect()->back()->withErrors(['current_password' => trans('validation.current_password')]);
      }

      $user->password = Hash::make($request->input('new_password'));
      $user->save();

      return redirect()->back()->with('success_message', trans('parameters.personal.update_password_success'));
   }

   /**
   * Update company information
   *
   * @return Redirect
   */
   public function updateCompany(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
         'company_name' => 'max:80|required',
         'company_registration_number' => 'max:50',
         'company_address_1' => 'max:191|required',
         'company_address_2' => 'max:191',
         'company_zipcode' => 'max:10|required',
         'company_city' => 'max:191|required',
         'company_phone' => 'max:25',
         'company_country_id' => 'exists:zones,id|required',
         'company_region_id' => 'exists:zones,id|nullable',
      ]);

      $user->company->update([
         'name' => $request->input('company_name'),
         'registration_number' => $request->input('company_registration_number'),
         'address_1' => $request->input('company_address_1'),
         'address_2' => $request->input('company_address_2'),
         'zipcode' => $request->input('company_zipcode'),
         'city' => $request->input('company_city'),
         'phone' => $request->input('company_phone'),
         'country_id' => $request->input('company_country_id'),
         'region_id' => $request->input('company_region_id'),
      ]);

      return redirect()->route('parameters_company')->with('success_message', trans('parameters.update_informations'));;
   }

   /**
   * Update credit card
   *
   * @return Redirect
   */
   public function updateCreditCard(Request $request) {
      $user = Auth::user();

      try {
         // Update credit card
         $user->updateCard($request->input('stripeToken'));
      } catch(\Exception $e) {
         $body = $e->getJsonBody();
         $err  = $body['error'];

         return redirect()->back()->withInput()->with('popup', trans('popups.stripe_errors.' . $err['code']));
      }

      $user->update([
         'card_exp_month' => $request->input('cc_exp_month'),
         'card_exp_year' => $request->input('cc_exp_year'),
      ]);

      return redirect()->route('parameters_subscription')->with('success_message', trans('parameters.udate_card'));
   }

   /**
   * Update SEPA
   *
   * @return Redirect
   */
   public function updateSepa(Request $request) {
      $user = Auth::user();
      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      $customer = \Stripe\Customer::retrieve($user->stripe_id);
      $customer->sources->create(array("source" => $request->input('stripeToken')));

      $customer->default_source = $request->input('stripeToken');
      $customer->save();

      $user->update([
         'iban' => $request->input('sepa_iban'),
         'iban_owner' => $request->input('sepa_name'),
      ]);

      return redirect()->route('parameters_subscription')->with('success_message', trans('parameters.udate_card'));
   }

   /**
   * Update subscription plan
   *
   * @return Redirect
   */
   public function upgradeSubscription(Request $request) {
      $user = Auth::user();

      $user->subscription($user->type)->swap($request->input('subscription'));

      return redirect()->route('parameters_subscription')->with('success_message', trans('parameters.update_plan'));
   }

   /**
   * Renew subscription plan
   *
   * @return Redirect
   */
   public function renewSubscription(Request $request) {
      $user = Auth::user();

      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      $subscription = $user->newSubscription($user->type, $request->input('subscription'));

      try {
         // Create subscription
         $subscription->create($request->input('stripeToken'), [
            'email' => $user->email
         ]);
      } catch(\Exception $e) {
         $body = $e->getJsonBody();
         $err  = $body['error'];

         return redirect()->back()->withInput()->with('popup', trans('popups.stripe_errors.' . $err['code']));
      }

      // Update user
      $user->update([
         'card_exp_month' => $request->input('cc_exp_month'),
         'card_exp_year' => $request->input('cc_exp_year'),
      ]);

      return redirect()->route('parameters_subscription')->with('success_message', trans('parameters.update_plan'));
   }

   /**
   * Update email
   *
   * @return Redirect
   */
   public function updateIdentification(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
         'new_email' => 'email|nullable|unique:users,email',
         'new_email_confirmation' => 'email|nullable',
      ]);

      $user->update([
         'email' => $request->input('new_email'),
      ]);

      return redirect()->route('parameters_credentials')->with('success_message', trans('parameters.update_informations'));
   }

   /**
   * Cancel subscription
   *
   * @return Redirect
   */
   public function cancelSubscription(Request $request) {
      $user = Auth::user();

      $user->subscription($user->type)->cancel();

      return redirect()->route('parameters_subscription')->with('success_message', trans('parameters.update_plan'));
   }

   /**
   * Download invoice
   *
   * @return Response
   */
   public function downloadInvoice($id) {
      $invoice = Invoice::find($id);

      if( !$invoice ) {
         abort(404);
      }

      return $invoice->download();
   }

   /**
   * Update billing information
   *
   * @return Redirect
   */
   public function userBilling(Request $request) {
      $user = Auth::user();

      $this->validate($request, [
         'billing_company_name' => 'max:140|required',
         'billing_name' => 'max:100|required',
         'billing_address_1' => 'max:191|required',
         'billing_address_2' => 'max:191',
         'billing_zipcode' => 'max:10|required',
         'billing_city' => 'max:191|required',
         'billing_country_id' => 'exists:zones,id|required',
      ]);

      $user->update([
         'billing_company_name' => $request->input('billing_company_name'),
         'billing_name' => $request->input('billing_name'),
         'billing_address_1' => $request->input('billing_address_1'),
         'billing_address_2' => $request->input('billing_address_2'),
         'billing_city' => $request->input('billing_city'),
         'billing_zipcode' => $request->input('billing_zipcode'),
         'billing_country_id' => $request->input('billing_country_id'),
      ]);

      return redirect()->back()->with('success_message', trans('parameters.personal.update_information_success'));
   }

}
