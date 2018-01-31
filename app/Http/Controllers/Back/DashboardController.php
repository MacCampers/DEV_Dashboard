<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Hash;

class DashboardController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show nothing for the moment
   *
   * @return View
   */
   public function index() {
      return redirect('/admin/companies');
      // return view('back.index');
   }

   /**
   * Check authenticated admin's password
   *
   * @return Response
   */
   public function checkPassword(Request $request) {
      return response()->json(['success' => Hash::check($request->input('password'), Auth::guard('admin')->user()->password)]);
   }

}
