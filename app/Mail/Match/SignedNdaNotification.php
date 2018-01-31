<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Signatory;
use App\Match;

class SignedNdaNotification extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $match;
   public $link;
   public $with;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Signatory $signatory, Match $match) {
      $this->user = $signatory->user;
      $this->match = $match;
      $this->link = route('match_view_nda', ['id' => $match->id]);

      $access = $this->user->getMatchAccess($match);

      $this->with = $access === 'project' ? $match->matchable->full_name : $match->project->company_name;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.signature.nda_confirmation')->subject(trans('emails.nda_signature_confirmation.subject', ['project' => $this->match->project->code_name]));
   }
}
