<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Mail\Account\SubscriptionCancelled;

use App\User;

use Excel;
use Auth;
use Mail;

class UsersController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show users list
   *
   * @return View
   */
   public function index(Request $request) {

      // TEMPORARY REDIRECTION BASED ON ADMIN ROLE
      if( Auth::guard('admin')->user()->role === 'cdd' ) {
         return redirect('/admin/companies/create');
      }

      if( $request->input('s') !== null && $request->input('s') !== '' ) {
         $search = '%'.$request->input('s').'%';

         $users = User::with('company')
                     ->where('first_name', 'like', $search)
                     ->orWhere('last_name', 'like', $search)
                     ->orWhere('email', 'like', $search)
                     ->orWhereHas('company', function($q) use($search) {
                        $q->where('name', 'like', $search);
                     })
                     ->sortable(['created_at' => 'desc'])->paginate(100);
      } else {
         $users = User::with('company')->sortable(['created_at' => 'desc'])->paginate(100);
      }

      return view('back.users.index')->with(['users' => $users]);
   }

   /**
   * Show creation form
   *
   * @return View
   */
   public function create() {
      return view('back.users.create');
   }

   /**
   * Show edition form
   *
   * @return View
   */
   public function edit($id) {
      $user = User::with('company')->find($id);
      $subscription = $user->subscription($user->type);

      return view('back.users.edit')->with(['user' => $user, 'subscription' => $subscription]);
   }

   /**
   * Update user
   *
   * @return Redirect
   */
   public function update(Request $request, $id) {
      // Validate form
      $this->validate($request, [
         'first_name' => 'required',
         'last_name' => 'required',
         'email' => 'email|required',
         'phone_fixed' => 'between:6,25|nullable',
         'phone_mobile' => 'between:6,25|nullable',
         'birth_date' => 'date_format:d/m/Y|nullable',
      ]);

      $company = User::find($id)->update([
         'title' => $request->input('title'),
         'job' => $request->input('job'),
         'first_name' => $request->input('first_name'),
         'last_name' => $request->input('last_name'),
         'email' => $request->input('email'),
         'phone_fixed' => $request->input('phone_fixed'),
         'phone_mobile' => $request->input('phone_mobile'),
         'birth_date' => $request->input('birth_date') ? Carbon::createFromFormat('d/m/Y', $request->input('birth_date'))->format('Y-m-d') : null,
         'linkedin_url' => $request->input('linkedin_url'),
         'viadeo_url' => $request->input('viadeo_url'),
      ]);

      return redirect('/admin/users/'. $id .'/edit')->with('success_message', "Les informations du contact ont été mises à jour.");

   }

   /**
   * Search user by name or email
   *
   * @return User
   */
   public function search(Request $request) {
      $search = '%'. $request->input('s') .'%';

      $users = User::where('last_name', 'like', $search)->orWhere('first_name', 'like', $search)->orWhere('email', 'like', $search)->get();

      return $users;
   }

   /**
   * Delete user
   *
   * @return Redirect
   */
   public function destroy($id) {
      $user = User::findOrFail($id);

      // Cancel subscription if the user is subscribed
      if( $user->subscribed($user->type) ) {
         $user->subscription($user->type)->cancelNow();

         // Send an email to the user
         Mail::to($user)->send(new SubscriptionCancelled($user));
      }

      $user->delete();

      return redirect('/admin/users')->with('success_message', "Le contact a été supprimé.");
   }

   /**
   * Cancel subscription
   */
   public function cancelSubscription($id) {
      $user = User::findOrFail($id);

      $user->subscription($user->type)->cancelNow();

      // Send an email to the user
      Mail::to($user)->send(new SubscriptionCancelled($user));

      return redirect('/admin/users/'. $id .'/edit')->with('success_message', "L'abonnement du contact a été annulé.");
   }

   /**
   * Export users
   */
   public function export(Request $request) {
      $users = User::all();

      $excelData = [];

      foreach( $users as $user ) {
         $excelData[] = array(
            '#' => $user->id,
            'Titre' => $user->title,
            'Prénom' => $user->first_name,
            'Nom' => $user->last_name,
            'Type' => trans('fields.account_types.'.$user->type, [], 'fr'),
            'Fonction' => $user->job,
            'Email' => $user->email,
            'Téléphone fixe' => $user->phone_fixed,
            'Téléphone mobile' => $user->phone_mobile,
            'Date de naissance' => $user->birth_date !== null ? \PHPExcel_Shared_Date::PHPToExcel(Carbon::createFromFormat('Y-m-d', $user->birth_date)->timestamp) : '',
            'LinkedIn' => $user->linkedin_url,
            'Viadeo' => $user->viadeo_url,
            'Inscrit le' => \PHPExcel_Shared_Date::PHPToExcel(Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->timestamp)
         );
      }

      Excel::create('Contacts', function($excel) use($excelData) {
         $excel->sheet('Contacts', function($sheet) use($excelData) {
            // Set multiple column formats
            $sheet->setColumnFormat(array(
               'A' => '0',
               'I' => 'dd/mm/yyyy',
               'L' => 'dd/mm/yyyy hh:mm'
            ));

            $sheet->freezeFirstRow();
            $sheet->setAutoFilter('A1:L1');
            $sheet->setHeight(1, 25);

            $sheet->fromArray($excelData, null, 'A1', true);

            // Styles
            $sheet->cells('A1:L1', function($cells) {
               $cells->setBackground('#00b2ff');
               $cells->setFontColor('#ffffff');
               $cells->setFontWeight('bold');
               $cells->setValignment('center');
            });
            $sheet->cells('A2:L'.$sheet->getHighestRow(), function($cells) {
               $cells->setValignment('top');
            });
         });
      })->download('xlsx');
   }

}
