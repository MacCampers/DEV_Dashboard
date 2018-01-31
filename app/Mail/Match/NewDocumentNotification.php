<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;

class NewDocumentNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $type;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match, $type) {
      $this->match = $match;
      $this->type = $type;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.new_document')->subject(trans('emails.new_'. $this->type .'.subject'));
   }
}
