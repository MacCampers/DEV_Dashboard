<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Match;
use App\User;

use Auth;

class NewNdaVersion extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $user;
   public $link;
   public $with;
   public $access;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Match $match, $access) {
      $this->match = $match;
      $this->access = $access;
      $this->link = route('match_view_nda', ['id' => $match->id]);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.match.nda_update')->subject(trans('emails.nda_update.subject', ['project' => $this->match->project->code_name]));
   }
}
