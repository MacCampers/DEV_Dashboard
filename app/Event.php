<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

   protected $table = 'events';
   protected $fillable = ['name', 'date', 'description', 'project_id'];
   public $timestamps = false;

   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getDateAttribute($date) {
      return date('d/m/Y', strtotime($date));
   }

}
