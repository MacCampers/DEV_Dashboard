<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Invoice;

class InvoicesController extends Controller {

   public function __construct() {
      $this->middleware('admin');
   }

   /**
   * Show invoices list
   *
   * @return View
   */
   public function index(Request $request) {
      if( $request->input('s') !== null && $request->input('s') !== '' ) {
         $search = '%'.$request->input('s').'%';

         $invoices = Invoice::with('user')->where('id', 'like', $search)->sortable(['date' => 'desc'])->paginate(100);
      } else {
         $invoices = Invoice::with('user')->sortable(['date' => 'desc'])->paginate(100);
      }

      return view('back.invoices.index')->with(['invoices' => $invoices]);
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

}
