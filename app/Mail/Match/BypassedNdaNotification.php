<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;

class BypassedNdaNotification extends Mailable {
   use Queueable, SerializesModels;

   public $project;
   public $link;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match) {
      $this->project = $match->project->code_name;
      $this->link = route('match_overview', ['id' => $match->id]);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.nda_bypass')->subject(trans('emails.nda_bypass.subject', ['project' => $this->project]));
   }
}
