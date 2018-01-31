<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Company extends Model {

   use Sortable;

   protected $table = 'companies';
   protected $fillable = ['name', 'type', 'category', 'registration_number', 'address_1', 'address_2', 'zipcode', 'city', 'country_id', 'region_id', 'email', 'phone', 'website', 'representative_id', 'deals_per_year', 'confirmed'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function representative() {
      return $this->hasOne('App\User', 'company_id')->where('company_role', 'representative');
   }

   public function users() {
      return $this->hasMany('App\User', 'company_id');
   }

   public function strategies() {
      return $this->hasMany('App\Strategy', 'company_id');
   }

   public function country() {
      return $this->belongsTo('App\Zone', 'country_id');
   }

   public function region() {
      return $this->belongsTo('App\Zone', 'region_id');
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */

   // Get company full postal address
   public function getFullAddress() {
      $address = $this->address_1;
      $address .= $this->address_2 !== null ? '<br />' . $this->address_2 : '';
      $address .= '<br />' . $this->zipcode.' '.$this->city;
      $address .= '<br />' . trans('zones.country.'. $this->country->code);

      return $address;
   }

   // Get all projects through users
   public function getProjects() {
      $projects = collect();
      $users = $this->users->load('projects');

      foreach( $users as $user ) {
         $projects = $projects->merge($user->projects);
      }

      return $projects;
   }

   // Check if the representative is subscribed
   public function isSubscribed() {
      return $this->representative->subscribed($this->representative->type);
   }


   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */
   public function getAdminsAttribute() {
      return $this->users->where('company_role', 'admin');
   }

   public function getActiveUsersAttribute() {
      return $this->users->where('company_role', '<>', 'pending');
   }

   public function getPendingUsersAttribute() {
      return $this->users->where('company_role', 'pending');
   }

}
