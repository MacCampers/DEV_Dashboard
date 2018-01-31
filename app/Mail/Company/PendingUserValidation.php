<?php

namespace App\Mail\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class PendingUserValidation extends Mailable {
   use Queueable, SerializesModels;

   public $user;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user) {
      $this->user = $user;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.company.pending_user_validation')->subject(trans('emails.pending_user_validation.subject', ['company' => $this->user->company->name]));
   }
}
