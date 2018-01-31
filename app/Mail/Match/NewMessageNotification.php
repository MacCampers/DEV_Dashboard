<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;

class NewMessageNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $body;
   public $sender;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match, $body, $sender) {
      $this->match = $match;
      $this->body = $body;
      $this->sender = $sender;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      if( $this->body ) {
         return $this->view('emails.match.new_message')->subject(trans('emails.new_message.title', ['sender' => $this->sender]));
      } else {
         return $this->view('emails.match.new_attachment')->subject(trans('emails.new_attachment.title', ['sender' => $this->sender]));
      }
   }
}
