<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model {

   protected $table = 'branches';
   protected $fillable = ['name', 'registration_number', 'address_1', 'address_2', 'zipcode', 'city', 'region_id', 'country_id', 'corporate_representative', 'shareholding', 'project_id'];
   public $timestamps = false;

   public function country() {
      return $this->belongsTo('App\Zone', 'country_id');
   }

   public function region() {
      return $this->belongsTo('App\Zone', 'region_id');
   }

}
