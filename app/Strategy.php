<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Strategy extends Model {

   use Sortable;

   protected $table = 'strategies';
   protected $fillable = ['name', 'company_id', 'value_min', 'value_max', 'amount_min', 'amount_max', 'revenues_min', 'revenues_max', 'value_min_equiteasy', 'value_max_equiteasy', 'amount_min_equiteasy', 'amount_max_equiteasy', 'revenues_min_equiteasy', 'revenues_max_equiteasy', 'majority', 'minority', 'profitable', 'company_size', 'mbi', 'social_impact', 'notes', 'confirmed'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function company() {
      return $this->belongsTo('App\Company', 'company_id');
   }

   public function zones() {
      return $this->belongsToMany('App\Zone', 'strategy_zone', 'strategy_id', 'zone_id')->withPivot('type');
   }

   public function activity_areas() {
      return $this->belongsToMany('App\ActivityArea', 'strategy_activity_area', 'strategy_id', 'activity_area_id')->withPivot('type');
   }

   public function development_stages() {
      return $this->belongsToMany('App\DevelopmentStage', 'strategy_development_stage', 'strategy_id', 'development_stage_id');
   }

   public function users() {
      return $this->belongsToMany('App\User', 'strategy_user', 'strategy_id', 'user_id');
   }

   public function matches() {
      return $this->morphMany('App\Match', 'matchable')->where('selected', 1)->where('accepted', 1);
   }

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getCompanyTypeAttribute($type) {
      return trans('fields.company_types.'.$type);
   }

   public function getCreatedAtAttribute($date) {
      return date('d/m/Y', strtotime($date));
   }

   // Returns company name if it's equal to strategy name
   public function getFullNameAttribute() {
      return $this->name === $this->company->name ? $this->name : $this->company->name .' - '. $this->name;
   }

   // Returns official activity areas
   public function getLocationsAttribute() {
      return $this->zones->where('pivot.type', 'location');
   }

   // Returns official activity areas
   public function getInvestmentZonesAttribute() {
      return $this->zones->where('pivot.type', 'investment');
   }

   // Returns official activity areas
   public function getOfficialActivityAreasAttribute() {
      return $this->activity_areas->where('pivot.type', 'official');
   }

   // Returns official activity areas
   public function getPrivilegedActivityAreasAttribute() {
      return $this->activity_areas->where('pivot.type', 'privileged');
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */

   // Get number of activity areas by type
   public function getActivityAreasCount($type = null) {
      if( $type ) {
         $attr = $type.'_activity_areas';
         $activityAreas = $this->$attr;
      } else {
         $activityAreas = $this->activity_areas;
      }

      $array = [];
      foreach( $activityAreas as $area ) {
         if( !$area->parent ) {
            $array[] = $area->id;
         } elseif( !in_array($area->parent, $array) ) {
            $array[] = $area->parent;
         }
      }

      return sizeof($array);
   }

}
