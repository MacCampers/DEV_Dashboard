<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Company;

class CompanyAssociateCreation extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $company;
   public $password;
   public $host;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, Company $company, $password, $host) {
      $this->user = $user;
      $this->company = $company;
      $this->password = $password;
      $this->host = $host;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.associated_account_creation')->subject(trans('emails.project_account_creation.subject', ['company' => $this->company->name]));
   }
}
