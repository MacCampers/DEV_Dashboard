<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

use App\Mail\Account\NewInvoice;

use PDF;
use Storage;
use Auth;
use Mail;

class Invoice extends Model {

   use Sortable;

   protected $table = 'invoices';
   protected $fillable = ['id', 'user_id', 'stripe_invoice_id', 'uri', 'amount', 'date'];

   public $incrementing = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

   public function user() {
      return $this->belongsTo('App\User', 'user_id');
   }

   /*
   |--------------------------------------------------------------------------
   | Functions
   |--------------------------------------------------------------------------
   */

   // Generate PDF
   public function generate() {
      $invoice = $this->user->findInvoice($this->stripe_invoice_id);
      $subscription = $this->user->subscription($this->user->type);
      $customer = $this->user->asStripeCustomer();

      /*
      |--------------------------------------------------------------------------
      | Generate PDF
      |--------------------------------------------------------------------------
      */

      $pdf = PDF::loadView('documents.invoice', ['invoice' => $invoice, 'number' => $this->id, 'user' => $this->user, 'subscription' => $subscription, 'customer' => $customer]);
      $fileName = strtolower($this->id) . '.pdf';
      $uri = '_invoices/' . $fileName;

      // Save file
      Storage::put($uri, $pdf->output());

      $size = Storage::size($uri);

      $this->update([
         'amount' => $invoice->rawTotal()/100,
         'date' => $invoice->date(),
         'uri' => $uri,
      ]);

      // Send invoice to user
      Mail::to($this->user)->send(new NewInvoice($this));
   }

   // Generate PDF
   public function download() {
      if( Auth::guard('admin')->check() || Auth::id() === $this->user_id ) {
         $file = $this->uri;
         $name = $this->id . '.pdf';

         return response()->stream(function() use($file, $name) {
            $stream = Storage::readStream($file);
            fpassthru($stream);
            if( is_resource($stream) ) {
               fclose($stream);
            }
         }, 200, [
            "Content-Type" => Storage::mimeType($file),
            "Content-Length" => Storage::size($file),
            "Content-disposition" => "inline; filename=\"". $name ."\"",
         ]);
      }

      abort(403);
   }

}
