<?php

namespace App\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;

class PasswordResetLink extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $token;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, $token) {
      $this->user = $user;
      $this->token = $token;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.account.reset_password')->subject(trans('emails.password_reset.subject'));
   }
}
