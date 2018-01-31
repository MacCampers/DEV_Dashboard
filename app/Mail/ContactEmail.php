<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactEmail extends Mailable {
   use Queueable, SerializesModels;

   public $name;
   public $email;
   public $title;
   public $body;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct($name, $email, $title, $body) {
      $this->name = $name;
      $this->email = $email;
      $this->title = $title;
      $this->body = nl2br($body);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.contact')->from($this->email, $this->name)->subject('Contact Equiteasy - ' . $this->title);
   }
}
