<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;
use App\Offer;

class DeclinedDocumentNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $offer;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match, Offer $offer) {
      $this->match = $match;
      $this->offer = $offer;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.declined_document')->subject(trans('emails.declined_'. $this->offer->type .'.subject', ['project' => $this->match->project->code_name]));
   }
}
