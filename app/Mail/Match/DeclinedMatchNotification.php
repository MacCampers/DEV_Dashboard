<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;
use App\Offer;

class DeclinedMatchNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match) {
      $this->match = $match;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.declined_match')->subject(trans('emails.declined_match.subject'));
   }
}
