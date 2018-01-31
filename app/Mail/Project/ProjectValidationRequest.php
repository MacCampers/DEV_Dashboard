<?php

namespace App\Mail\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Project;

class ProjectValidationRequest extends Mailable {
   use Queueable, SerializesModels;

   public $project;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(Project $project) {
      $this->project = $project;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.project.validation_request')->subject('Projet ' . $this->project->code_name . ' à valider');
   }
}
