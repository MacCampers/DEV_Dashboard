<?php

namespace App\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Invoice;

class NewInvoice extends Mailable {
   use Queueable, SerializesModels;

   public $invoice;
   public $date;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Invoice $invoice) {
      $this->invoice = $invoice;
      $this->date = date('d/m/Y', strtotime($invoice->date));
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.account.new_invoice')->subject(trans('emails.new_invoice.subject', ['date' => $this->date]));
   }
}
