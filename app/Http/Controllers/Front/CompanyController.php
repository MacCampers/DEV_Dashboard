<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Mail\Company\CompanyAccountCreation;
use App\Mail\Company\PendingUserValidation;
use App\Mail\Company\PendingUserRefusal;
use App\Mail\Company\StrategyCreationRequest;
use App\Mail\Company\StrategyUpdateRequest;
use App\Mail\Company\CompanyAssociateCreation;
use App\Mail\Company\CompanyAssociateRemoval;
use App\Mail\Company\CompanyAccountRemoval;

use App\Company;
use App\User;
use App\Strategy;
use App\Zone;

use Auth;
use Mail;
use Hash;
use Validator;

class CompanyController extends Controller {

   /**
   * Show company edition form
   *
   * @return View
   */
   public function information() {
      if( Auth::user()->company_role === 'pending' ) {
         abort(403);
      }

      $zones = Zone::all();
      $countries = $zones->where('type', 'country');
      $regions = $zones->where('type', 'region');

      $data = [
         'user' => Auth::user(),
         'company' => Auth::user()->company,
         'countries' => $countries,
         'regions' => $regions,
      ];

      return view('front.dashboard.company.information', $data);
   }

   /**
   * Show strategy edition form
   *
   * @return View
   */
   public function strategies() {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         return view('front.dashboard.company.strategies', ['company' => Auth::user()->company]);
      }

      abort(403);
   }

   /**
   * Show strategy creation request form
   *
   * @return View
   */
   public function requestStrategyCreation() {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         return view('front.dashboard.company.strategy.request', ['user' => $user]);
      }

      abort(403);
   }

   /**
   * Show strategy creation request form
   *
   * @return View
   */
   public function requestStrategyUpdate($id) {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         $strategy = Strategy::find($id);
         $company = $user->company;

         return view('front.dashboard.company.strategy.request_update', ['user' => $user, 'strategy' => $strategy, 'company' => $company]);
      }

      abort(403);
   }


   /**
   * Show members edition form
   *
   * @return View
   */
   public function members() {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         $zones = Zone::all();
         $data = [
            'company' => Auth::user()->company,
            'user' => Auth::user(),
         ];

         return view('front.dashboard.company.members', $data);
      }

      abort(403);
   }

   /**
   * Update information company
   *
   * @return Redirect
   */
   public function updateInformation(Request $request) {
      $user = Auth::user();

      if( $user->is_admin ) {
         $this->validate($request, [
            'company_name' => 'max:80|required',
            'company_registration_number' => 'max:50|nullable',
            'company_address_1' => 'max:191|required',
            'company_address_2' => 'max:191|nullable',
            'company_zipcode' => 'max:10|required',
            'company_city' => 'max:191|required',
            'company_country_id' => 'exists:zones,id|required',
            'company_region_id' => 'exists:zones,id|nullable',
            'company_phone' => 'max:25|nullable',
         ]);

         $user->company->update([
            'name' => $request->input('company_name'),
            'registration_number' => $request->input('company_registration_number'),
            'address_1' => $request->input('company_address_1'),
            'address_2' => $request->input('company_address_2'),
            'city' => $request->input('company_city'),
            'zipcode' => $request->input('company_zipcode'),
            'country_id' => $request->input('company_country_id'),
            'region_id' => $request->input('company_region_id'),
            'phone' => $request->input('company_phone'),
         ]);

         return redirect()->route('company_information')->with('success_message', trans('parameters.information_updated'));
      }
   }


   /**
   * Create strategy
   *
   * @return Redirect
   */
   public function sendStrategyCreationRequest(Request $request) {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         $company = $user->company;

         $this->validate($request, [
            'user_phone_number' => 'required',
            'message' => 'required',
         ]);

         Mail::to(env('SUPPORT_EMAIL'))->send(new StrategyCreationRequest($company, $request->input('user_phone_number'), $request->input('message'), $user->full_name));

         return redirect()->route('company_strategies')->with('popup', trans('parameters.company.strategies.request_success'));
      }

      abort(403);
   }


   /**
   * Create strategy
   *
   * @return Redirect
   */
   public function sendStrategyUpdateRequest(Request $request, $id) {
      $user = Auth::user();

      if( $user->type === 'investor' && $user->is_admin ) {
         $company = $user->company;
         $strategy = Strategy::find($id);

         $this->validate($request, [
            'user_phone_number' => 'required',
            'message' => 'required',
         ]);

         Mail::to(env('SUPPORT_EMAIL'))->send(new StrategyUpdateRequest($company, $request->input('user_phone_number'), $request->input('message'), $strategy, $user));

         return redirect()->route('company_strategies')->with('popup', trans('parameters.company.strategies.request_success'));
      }

      abort(403);
   }


   /**
   * Add new user and attach him to the company
   *
   * @return Redirect
   */
   public function addUser(Request $request, $companyId) {
      if( Auth::user()->is_admin && Auth::user()->company_id == $companyId ) {
         $this->validate($request, [
            'user_first_name' => 'required|max:60',
            'user_last_name' => 'required|max:60',
            'user_email' => 'required|unique:users,email|email',
            'user_phone_number' => 'max:25',
         ]);

         $company = Company::find($companyId);
         if( $company->type === 'investment' ) {
            $userType = 'investor';
         } elseif( $company->type === 'counsel' ) {
            $userType = 'advisor';
         } elseif( $company->type === 'company' ) {
            $userType = 'contractor';
         } else {
            $userType = 'guest';
         }

         // Generate random password
         $password = str_random(16);

         $user = User::create([
            'type' => $userType,
            'first_name' => $request->input('user_first_name'),
            'last_name' => $request->input('user_last_name'),
            'email' => $request->input('user_email'),
            'password' => Hash::make($password),
            'phone_mobile' => $request->input('user_phone_number'),
            'company_id' => $companyId,
            'company_role' => $request->has('user_role') ? $request->input('user_role') : 'guest',
            'confirmed' => true,
            'source' => 'advisor_associate',
         ]);

         if( $request->has('user_strategies') ) {
            $user->strategies()->attach($request->input('user_strategies'));
         }

         Mail::to($user)->send(new CompanyAccountCreation($user, $password));

         return redirect()->back()->with('success_message', trans('parameters.company.members.member_added', ['name' => $user->full_name]));
      }

      abort(403);
   }

   /**
   * Detach user from company
   *
   * @return Redirect
   */
   public function deleteUser($companyId, $userId) {
      if( Auth::user()->is_admin && Auth::user()->company_id == $companyId ) {
         $user = User::find($userId);
         $company = Company::find($companyId);

         foreach( $user->strategies as $strategy ) {
            if( $strategy->users->count() === 1) {
               $company->representative->strategies()->attach($strategy->id);
            }
         }

         // Send an email to the deleted user
         Mail::to($user)->send(new CompanyAccountRemoval($user, $company));

         $userName = $user->full_name;

         // Delete user
         $user->delete();

         return redirect()->route('company_members')->with('success_message', trans('parameters.company.members.member_deleted', ['name' => $userName]));
      }

      abort(403);
   }

   /**
   * Accept pending user's request
   *
   * @return Redirect
   */
   public function acceptUser($companyId, $userId) {
      if( Auth::user()->is_admin && Auth::user()->company_id == $companyId ) {
         $user = User::find($userId);

         $user->update(['company_role' => 'guest']);

         Mail::to($user)->send(new PendingUserValidation($user));

         return redirect()->route('company_members')->with('success_message', trans('parameters.company.members.member_accepted', ['name' => $user->full_name]));
      }

      abort(403);
   }

   /**
   * Decline pending user's request
   *
   * @return Redirect
   */
   public function declineUser($companyId, $userId) {
      if( Auth::user()->is_admin && Auth::user()->company_id == $companyId ) {
         $user = User::find($userId);
         $company = Company::find($companyId);

         $user->update([
            'company_id' => null,
            'company_role' => null,
         ]);

         Mail::to($user)->send(new PendingUserRefusal($user, $company));

         $userName = $user->full_name;

         // Delete user
         $user->delete();

         return redirect()->route('company_members')->with('success_message', trans('parameters.company.members.member_declined', ['name' => $userName]));
      }

      abort(403);
   }

   /**
   * Change user role
   *
   * @return Responsse
   */
   public function switchUserRole(Request $request, $companyId, $userId) {
      if( Auth::user()->is_admin && Auth::user()->company_id == $companyId ) {
         $user = User::find($userId);

         $user->update([
            'company_role' => $request->input('admin') === 'true' ? 'admin' : 'guest'
         ]);

         return response()->json(['error' => false]);
      }

      return response()->json(['error' => true]);
   }


   /**
   * Change user role
   *
   * @return Responsse
   */
   public function switchUserStrategy(Request $request, $strategyId) {
      if( Auth::user()->is_admin ) {
         $user = User::find($request->input('userId'));
         $strategy = Strategy::find($strategyId);


         if( $request->input('checked') === 'true' ) {
            $strategy->users()->attach($user->id);
         } if( $strategy->users->count() > 1 && $request->input('checked') === 'false' ) {
            $strategy->users()->detach($user->id);
         }

         return response()->json(['error' => false]);
      }

      return response()->json(['error' => true]);
   }


   /**
   * Add new associate
   *
   * @return Redirect
   */
   public function addAssociate(Request $request, $companyId) {
      $company = Company::find($companyId);
      $host = Auth::user()->full_name;

      $this->validate($request, [
         'user_first_name' => 'required|max:60',
         'user_last_name' => 'required|max:60',
         'user_email' => 'required|email|unique:users,email',
         'user_phone_number' => 'max:25',
      ]);

      $password = str_random(16);

      $user = User::create([
         'type' => 'advisor',
         'first_name' => $request->input('user_first_name'),
         'last_name' => $request->input('user_last_name'),
         'email' => $request->input('user_email'),
         'password' => Hash::make($password),
         'phone_mobile' => $request->input('user_phone_number'),
         'company_role' => 'admin',
         'confirmed' => true,
         'company_id' => $company->id,
         'default_language' => 'fr',
      ]);

      Mail::to($user)->send(new CompanyAssociateCreation($user, $company, $password, $host));

      return redirect()->back()->with('success_message', trans('parameters.company.members.associate_added', ['user_name' => $user->full_name]));
   }

   /**
   * Delete associate
   *
   * @return Redirect
   */
   public function deleteAssociate(Request $request, $companyId, $userId) {
      $user = User::find($userId);
      $company = Company::find($companyId);

      // Send an email to the deleted user
      Mail::to($user)->send(new CompanyAssociateRemoval($user, $company));

      // Re-affect projects to the company representative
      $projects = $user->projects;
      foreach( $projects as $project ) {
         $project->update(['initiator_id' => $company->representative->id]);
      }

      $userName = $user->full_name;

      // Delete user
      $user->delete();

      return redirect()->back()->with('success_message', trans('parameters.company.members.associate_removed', ['user_name' => $userName]));
   }

}
