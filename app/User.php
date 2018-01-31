<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Cashier\Billable;
use Carbon\Carbon;

use Stripe\Stripe as Stripe;
use Stripe\Plan as StripePlan;

use App\Company;
use App\Project;
use App\Match;
use App\Document;

use App\Mail\Account\PasswordResetLink;
use App\Mail\Match\MatchNotification;

use Mail;

class User extends Authenticatable {

   use Billable;
   use Notifiable;
   use Sortable;

   protected $table = 'users';
   protected $fillable = ['type', 'title', 'first_name', 'last_name', 'email', 'phone_fixed', 'phone_mobile', 'password', 'birth_date', 'job', 'linkedin_url', 'viadeo_url', 'company_id', 'payment_method', 'stripe_id', 'iban', 'iban_owner', 'company_role', 'default_language', 'activation_code', 'subscription_ends_at', 'billing_company_name', 'billing_name', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_zipcode', 'billing_country_id', 'confirmed', 'card_exp_month', 'card_exp_year', 'password_creation_token', 'source'];
   protected $hidden = ['password', 'remember_token'];
   protected $dates = ['trial_ends_at', 'subscription_ends_at'];

   public $sortable = ['last_name', 'email', 'type', 'created_at'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

   public function company() {
      return $this->belongsTo('App\Company', 'company_id');
   }

   public function strategies() {
      return $this->belongsToMany('App\Strategy', 'strategy_user', 'user_id', 'strategy_id');
   }

   public function projects() {
      return $this->hasMany('App\Project', 'initiator_id');
   }

   public function invitations() {
      return $this->belongsToMany('App\Project', 'user_project', 'user_id', 'project_id')->withPivot('admin');
   }

   public function invoices() {
      return $this->hasMany('App\Invoice', 'user_id')->orderBy('date', 'desc');
   }

   public function billing_country() {
      return $this->belongsTo('App\Zone', 'billing_country_id');
   }

   public function matches() {
      return $this->morphMany('App\Match', 'matchable')->where('selected', 1)->where('accepted', 1);
   }


   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getFullNameAttribute() {
      return $this->first_name.' '.$this->last_name;
   }

   public function getIsAdminAttribute() {
      return $this->company_role === 'admin' || $this->company_role === 'representative';
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */

   // Get user full billing address
   public function getFullBillingAddress() {
      $address = $this->billing_address_1;
      $address .= $this->billing_address_2 !== null ? '<br />' . $this->billing_address_2 : '';
      $address .= '<br />' . $this->billing_zipcode.' '.$this->billing_city;
      $address .= $this->billing_country ? '<br />' . trans('zones.country.'. $this->billing_country->code) : '';

      return $address;
   }


   /*
   |--------------------------------------------------------------------------
   | Accesses
   |--------------------------------------------------------------------------
   */

   // Get access for a given project
   public function getProjectAccess(Project $project) {
      // Check if the user is the initiator of the project
      if( $project->initiator_id === $this->id ) {
         return $this->company_role;
      }

      // If the user is invited, get his role
      $guest = $project->guests()->where('user_id', $this->id)->first();
      if( $guest ) {
         return $guest->pivot->admin ? 'admin' : 'guest';
      }

      return null;
   }

   // Get access for a given match
   public function getMatchAccess(Match $match) {
      // If the user is an investor
      // Check if the match has been accepted
      // Check if one of his strategies belongs to the matched
      if( $this->type === 'investor' && $match->accepted ) {
         if( $match->matchable_type === 'user' && $match->matchable_id === $this->id ) {
            return 'strategy';
         } elseif( $match->matchable_type === 'strategy' && $this->strategies->contains($match->matchable) ) {
            return 'strategy';
         }
      }
      // If the user is a project manager
      // Check if he has acces to the project
      elseif( $this->getProjectAccess($match->project) ) {
         return 'project';
      }

      return null;
   }

   // Check access for a given document
   public function hasDocumentAccess(Document $document) {
      if( $this->getProjectAccess($document->project) ) {
         return true;
      }

      foreach( $document->project->selected_matches as $match ) {
         if( $this->getMatchAccess($match) ) {
            return true;
         }
      }

      return false;
   }


   /*
   |--------------------------------------------------------------------------
   | User abilities
   |--------------------------------------------------------------------------
   */

   // Check if user is a project manager (advisor or contractor)
   public function isProjectManager() {
      return $this->type === 'advisor' || $this->type === 'contractor';
   }

   // Check if the user is able to create a project
   public function canCreateProject() {
      if( $this->confirmed && $this->company->isSubscribed() ) {
         // If the user is an advisor, check if the number of projects created by his company during the past year is lower than 10
         if( $this->type === 'advisor' ) {
            $projects = $this->company->getProjects();
            $count = 0;

            foreach( $projects as $project ) {
               if( Carbon::parse($project->created_at)->gt(Carbon::now()->subYear()) ) {
                  $count++;
               }
            }

            return $count < 10;
         } elseif( $this->type === 'contractor' ) {
            return $this->projects->count() === 0;
         }
      }

      return false;
   }

   // Check if the user can edit an NDA
   public function canEditNda(Match $match) {
      if( !$match->isRunning() ) {
         return false;
      }

      return $this->type === 'investor' && !$match->nda_accepted_strategy || $this->isProjectManager() && !$match->nda_accepted_company && $match->nda_accepted_strategy;
   }

   // Check if the user must sign an NDA
   public function mustSignNda(Match $match) {
      if( !$match->isRunning() ) {
         return false;
      }

      if( $this->type === 'investor' && !$match->nda_accepted_strategy && $match->nda_accepted_company ) {
         return true;
      } elseif( ($this->type === 'advisor' || $this->type === 'contractor') && !$match->nda_accepted_company && $match->nda_accepted_strategy ) {
         return true;
      }

      return false;
   }


   /*
   |--------------------------------------------------------------------------
   | Cashier
   |--------------------------------------------------------------------------
   */

   // Get commitment end date
   public function getCommitmentEndDate() {
      $commitment = 0;

      $array = explode('_', $this->subscription($this->type)->stripe_plan);
      if( sizeof($array) > 1 ) {
         $commitment = intval($array[1]);
      }

      return $this->subscription($this->type)->updated_at->addMonths($commitment);
   }

   // Check if the user can cancel his subscription
   public function canCancel() {
      return $this->getCommitmentEndDate()->lt(Carbon::now());
   }

   // Check if the user is able to upgrade his subscription
   public function canUpgrade() {
      if( $this->canCancel() ) {
         return true;
      }

      if( $this->type === 'advisor' ) {
         return $this->subscription($this->type)->stripe_plan === 'advisor' || $this->subscription($this->type)->stripe_plan === 'advisor_12';
      } elseif( $this->type === 'contractor' ) {
         return $this->subscription($this->type)->stripe_plan === 'contractor';
      }

      return false;
   }

   // Set tax percentage
   public function taxPercentage() {
      return 20;
   }


   /*
   |--------------------------------------------------------------------------
   | Emails
   |--------------------------------------------------------------------------
   */

   public function sendPasswordResetNotification($token) {
      Mail::to($this)->send(new PasswordResetLink($this, $token));
   }

   public function sendMatchNotification(Match $match) {
      Mail::to($this)->send(new MatchNotification($this, $match));
      $match->update(['last_email' => Carbon::now()]);
   }

}
