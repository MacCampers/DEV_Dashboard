<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class CompanyAccountCreation extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $password;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, $password) {
      $this->user = $user;
      $this->password = $password;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.account_creation')->subject(trans('emails.company_account_creation.subject', ['company' => $this->user->company->name]));
   }
}
