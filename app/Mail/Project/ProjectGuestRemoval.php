<?php

namespace App\Mail\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Project;

class ProjectGuestRemoval extends Mailable {
   use Queueable, SerializesModels;

   public $user;
   public $project;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, Project $project) {
      $this->user = $user;
      $this->project = $project;
   }

   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.project.guest_removal')->subject(trans('emails.project_guest_removal.subject', ['project' => $this->project->code_name]));
   }
}
