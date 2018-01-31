<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Subscription;
use Carbon\Carbon;

use App\User;
use App\Zone;
use App\Company;

use App\Mail\Account\AccountActivation;
use App\Mail\Company\CompanyUserRequest;

use LaravelLocalization;
use Hash;
use Validator;
use Mail;

class RegisterController extends Controller {
   /*
   |--------------------------------------------------------------------------
   | Register Controller
   |--------------------------------------------------------------------------
   |
   | This controller handles the registration of new users as well as their
   | validation and creation. By default this controller uses a trait to
   | provide this functionality without requiring any additional code.
   |
   */

   use RegistersUsers;

   /**
   * Where to redirect users after registration.
   *
   * @var string
   */
   protected $redirectTo = '/';

   /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function __construct() {
      $this->middleware('guest');
   }

   /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
   protected function create(array $data) {
      return User::create([
         'name' => $data['name'],
         'email' => $data['email'],
         'password' => Hash::make($data['password']),
      ]);
   }

   /**
   * Show account type selector
   *
   * @return View
   */
   public function index(Request $request) {
      return view('front.auth.register.index');
   }

   /**
   * Redirect to registration form depending on the selected account type
   *
   * @return Redirect
   */
   public function registrationRedirect(Request $request) {
      return redirect()->route('registration_form', ['type' => $request->input('account_type')]);
   }

   /**
   * Show registration form
   *
   * @return View
   */
   public function showRegistrationForm($type) {
      $zones = Zone::all();
      $countries = $zones->where('type', 'country');
      $regions = $zones->where('type', 'region');

      return view('front.auth.register.' . $type, ['countries' => $countries, 'regions' => $regions]);
   }

   /**
   * Validate user form
   *
   * @return Response
   */
   public function validateUser(Request $request) {
      $validator = Validator::make($request->all(), [
         'user_first_name' => 'max:60|required',
         'user_last_name' => 'max:60|required',
         'user_email' => 'required|email|unique:users,email',
         'user_phone_mobile' => 'nullable|max:25',
         'user_password' => 'required|between:8,30|confirmed',
         'user_birth_date' => 'date_format:d/m/Y|nullable',
      ]);

      return response()->json(['errors' => $validator->errors()]);
   }

   /**
   * Validate company form
   *
   * @return Response
   */
   public function validateCompany(Request $request) {
      $validator = Validator::make($request->all(), [
         'company_name' => 'max:80|required',
         'company_registration_number' => 'max:50|required',
         'company_address' => 'max:191|required',
         'company_zipcode' => 'max:10|required',
         'company_city' => 'max:80|required',
         'company_country_id' => 'required|exists:zones,id',
         'company_region_id' => 'nullable|exists:zones,id',
      ]);

      return response()->json(['errors' => $validator->errors()]);
   }

   /**
   * Validate coupon
   *
   * @return Response
   */
   public function validateCoupon(Request $request) {
      $validator = Validator::make($request->all(), [
         'coupon' => 'required',
      ]);

      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

      try {
         $coupon = \Stripe\Coupon::retrieve(strtoupper($request->input('coupon')));

         if( $coupon->valid ) {
            return $coupon;
         } else {
            return response()->json(['error' => trans('validation.custom.coupon.expired')]);
         }
      } catch(\Exception $e) {
         return response()->json(['error' => trans('validation.custom.coupon.invalid')]);
      }
   }

   /**
   * Search company by name
   *
   * @return Response
   */
   public function autocompleteCompany(Request $request) {
      $search = $request->input('search').'%';

      $companies = Company::where('name', 'like', $search)->where('type', 'investment')->get();

      return response()->json(['companies' => $companies]);
   }

   /**
   * Register user
   *
   * @return Redirect
   */
   public function register(Request $request, $type) {

      // Set company type using user type
      switch($type) {
         case 'contractor':
         $companyType = 'company';
         break;
         case 'investor':
         $companyType = 'investment';
         break;
         case 'advisor':
         $companyType = 'counsel';
         break;
      }

      // Set validation rules for user
      $rules = [
         'user_title' => 'required',
         'user_first_name' => 'required|max:60',
         'user_last_name' => 'required|max:60',
         'user_email' => 'required|email|unique:users,email',
         'user_phone_mobile' => 'nullable|max:25',
         'user_password' => 'required|between:8,30|confirmed',
         'user_birth_date' => 'date_format:d/m/Y|nullable',
      ];

      if( $companyType === 'investment' && $request->input('company_id') ) {
         // If this is an investment company and the user chose a company in the autocompletion list, require an existing company id
         $rules = array_merge($rules, [
            'company_id' => 'exists:companies,id',
         ]);
      } else {
         // In every other case, set validation rules for company
         $rules = array_merge($rules, [
            'company_name' => 'max:80',
            'company_registration_number' => 'max:50',
            'company_address' => 'max:191|required',
            'company_address_2' => 'max:191|nullable',
            'company_zipcode' => 'max:10|required',
            'company_city' => 'max:80|required',
            'company_country_id' => 'required|exists:zones,id',
            'company_region_id' => 'nullable|exists:zones,id',
            'company_phone' => 'nullable|max:25',
         ]);
      }

      $subscription = false;
      $subscriptionEndsAt = null;

      // Set validation rules for subscription
      if( $companyType === 'company' ) {
         $subscription = true;
         $rules = array_merge($rules, [
            'subscription' => 'required|in:contractor,contractor_6',
         ]);
      } elseif( $companyType === 'counsel' ) {
         $subscription = true;
         $rules = array_merge($rules, [
            'subscription' => 'required|in:advisor,advisor_12,advisor_24',
         ]);
      }

      // Validate form
      $this->validate($request, $rules);

      if( $request->input('company_id') ) {
         // Get selected company
         $company = Company::find($request->input('company_id'));
      } else {
         if( $companyType === 'investment' && $request->input('company_category') === 'business_angel' ) {
            $companyName = $request->input('user_title') . ' ' . $request->input('user_first_name') . ' ' . $request->input('user_last_name');
         } else {
            $companyName = $request->input('company_name');
         }

         // Register company
         $company = Company::create([
            'name' => $companyName,
            'type' => $companyType,
            'category' => $request->input('company_category') ? $request->input('company_category') : null,
            'registration_number' => $request->input('company_registration_number'),
            'address_1' => $request->input('company_address'),
            'address_2' => $request->input('company_address_2'),
            'zipcode' => $request->input('company_zipcode'),
            'city' => $request->input('company_city'),
            'country_id' => $request->input('company_country_id'),
            'region_id' => $request->input('company_region_id'),
            'phone' => $request->input('company_phone'),
            'confirmed' => 0,
         ]);
      }

      // Register user
      $user = User::create([
         'title' => $request->input('user_title'),
         'first_name' => $request->input('user_first_name'),
         'last_name' => $request->input('user_last_name'),
         'type' => $type,
         'email' => $request->input('user_email'),
         'phone_mobile' => $request->input('user_phone_mobile'),
         'password' => Hash::make($request->input('user_password')),
         'birth_date' => $request->input('user_birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('user_birth_date')) : null,
         'company_id' => $company->id,
         'company_role' => $request->input('company_id') ? 'pending' : 'representative',
         'default_language' => LaravelLocalization::getCurrentLocale(),
         'activation_code' => str_random(30),
         'confirmed' => 0,
         'payment_method' => $request->input('payment_method'),
         'source' => $request->input('source')
      ]);

      // Create the Stripe customer
      if( $request->has('subscription') ) {
         \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

         $stripeCoupon = null;

         // Validate coupon if there is one
         if( $request->input('coupon') ) {
            $coupon = strtoupper($request->input('coupon'));
            try {
               $stripeCoupon = \Stripe\Coupon::retrieve($coupon);

               if( !$stripeCoupon->valid ) {
                  $stripeCoupon = null;
               }
            } catch(\Exception $e) {
               $stripeCoupon = null;
            }
         }

         // Initialize subscription
         if( $stripeCoupon ) {
            $subscription = $user->newSubscription($type, $request->input('subscription'))->withCoupon($coupon);
         } else {
            $subscription = $user->newSubscription($type, $request->input('subscription'));
         }

         // SEPA debit
         if( $request->input('payment_method') === 'sepa' ) {
            $customer = \Stripe\Customer::create([
               'email' => $request->input('user_email'),
               'source' => $request->input('stripeToken'),
            ]);

            $susbcriptionData = [
               'customer' => $customer,
               'items' => [
                  [
                     'plan' => $request->input('subscription'),
                  ],
               ],
            ];

            // Add coupon if there is one
            if( $stripeCoupon ) {
               $susbcriptionData['coupon'] = $coupon;
            }

            $stripeSubscription = \Stripe\Subscription::create($subscriptionData);

            // Create subscription
            Subscription::create([
               'user_id' => $user->id,
               'name' => $user->type,
               'stripe_id' => $stripeSubscription->id,
               'stripe_plan' => $request->input('subscription'),
               'quantity' => 1,
               'created_at' => Carbon::now(),
               'updated_at' => Carbon::now(),
            ]);

            // Update user
            $user->update([
               'stripe_id' => $customer->id,
               'iban' => $request->input('sepa_iban'),
               'iban_owner' => $request->input('sepa_name'),
            ]);

         }

         // Credit card
         else {
            try {
               // Create subscription
               $subscription->create($request->input('stripeToken'), [
                  'email' => $user->email
               ]);
            } catch(\Exception $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];

               // Remove user from database
               $user->company->delete();
               $user->delete();

               return redirect()->back()->withInput()->with('popup', trans('popups.stripe_errors.' . $err['code']));
            }

            // Update user
            $user->update([
               'card_exp_month' => $request->input('cc_exp_month'),
               'card_exp_year' => $request->input('cc_exp_year'),
            ]);
         }
      }

      // Send activation link
      Mail::to($user)->send(new AccountActivation($user));

      // If user has selected an existing company, send an email to its representative
      if( $request->input('company_id') ) {
         Mail::to($company->representative)->send(new CompanyUserRequest($company->representative, $user));
      }

      return redirect()->route('home')->with('popup', __('popups.registration.success'));
   }
}
