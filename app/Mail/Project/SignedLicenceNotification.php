<?php

namespace App\Mail\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Signatory;

class SignedLicenceNotification extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $document;
   public $link;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Signatory $signatory) {
      $this->user = $signatory->user;
      $this->document = $signatory->document;
      $this->link = route('project_edit', ['id' => $this->document->project_id, 'step' => 'agreements']);
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.signature.licence_confirmation')->subject(trans('emails.licence_signature_confirmation.subject'));
   }
}
