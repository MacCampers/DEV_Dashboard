<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class CompanyUserRequest extends Mailable {
   use Queueable, SerializesModels;

   public $representative;
   public $user;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $representative, User $user) {
      $this->representative = $representative;
      $this->user = $user;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.user_request')->subject(trans('emails.company_user_request.subject', ['user_name' => $this->user->full_name, 'company_name' => $this->user->company->name]));
   }
}
