<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Strategy;

use Auth;

class HomeController extends Controller {

   /**
   * Show homepage
   *
   * @return View
   */
   public function index() {
      $strategy = Strategy::all()->count();

      return view('front.home', ['strategy' => $strategy]);
   }
}
