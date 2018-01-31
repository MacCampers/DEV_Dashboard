<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevelopmentStage extends Model {

   protected $table = 'development_stages';

   public $timestamps = false;

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getNameAttribute() {
      return trans('development_stages.'. $this->code);
   }

}
