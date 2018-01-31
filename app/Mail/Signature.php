<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Project;
use App\Signatory;

class Signature extends Mailable {
   use Queueable, SerializesModels;

   public $project;
   public $signatory;
   public $user;
   public $type;
   public $link;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Project $project, Signatory $signatory) {
      $this->project = $project;
      $this->signatory = $signatory;
      $this->user = $signatory->user;
      $this->type = $signatory->document->section;
      $this->link = route('sign_document', ['signatoryId' => $signatory->id, 'token' => $signatory->yousign_token]);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.signature.new_document')->subject(trans('emails.signature.'. $this->type .'.subject'));
   }
}
