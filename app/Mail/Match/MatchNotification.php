<?php

namespace App\Mail\Match;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;
use App\Match;

use Mail;

class MatchNotification extends Mailable {
   use Queueable, SerializesModels;

   public $match;
   public $user;
   public $teaser;
   public $data;
   public $link;

   /**
   * Create a new message instance.
   *
   * @return void
   */
   public function __construct(User $user, Match $match) {
      $this->match = $match;

      $project = $match->project;

      $this->data = [
         'code_name' => $project->code_name,
         'country' => $project->company_country->name,
         'type' => trans('fields.project.synthesis.'. $project->type),
      ];

      if( $project->type === 'fundraising' ) {
         $this->data['amount_searched'] = number_format($project->amount_searched, 0, ',', ' ') . ' ' . $project->currency_symbol;
      } else {
         $this->data['turnover'] = number_format(round($project->turnover_m_1, -5), 0, ',', ' ') . ' ' . $project->currency_symbol;
      }

      $this->data['development_stage'] = $project->development_stage->name;

      foreach( $project->activity_areas as $activityArea ) {
         $this->data['activity_areas'][] = $activityArea->name;
      }

      $this->teaser = $project->getField('teaser_mail');
      $this->user = $user;

      $routeData = [
         'id' => $match->id,
         'email' => $user->email
      ];
      if( !$user->password ) {
         $user->password_creation_token = str_random(60);
         $user->save();

         $routeData['token'] = $user->password_creation_token;
      }
      $this->link = route('match_teaser', $routeData);
   }


   /**
   * Build the message.
   *
   * @return $this
   */
   public function build() {
      return $this->view('emails.project.match')->subject(trans('emails.match.subject_' .  $this->match->matchable_type , ['strategy' => $this->match->matchable->name, 'user' => $this->match->project->initiator->full_name]));
   }
}
