<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Company;

class CompanyAssociateRemoval extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $company;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, Company $company) {
      $this->user = $user;
      $this->company = $company;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.associated_account_removal')->subject(trans('emails.company_associated_account_removal.subject', ['company' => $this->company->name]));
   }
}
