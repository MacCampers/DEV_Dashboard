<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;

class MatchStoppedNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $initiator;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match) {
      $this->match = $match;
      $this->initiator = ($match->ended_by === 'project' ? $match->project->company_name : $match->matchable->full_name);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.stopped_match')->subject(trans('emails.'. $this->match->ended_by .'_stopped_match.title', ['initiator' => $this->initiator, 'project' => $this->match->project->code_name]));
   }
}
