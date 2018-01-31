<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

   protected $table = 'transactions';
   protected $fillable = ['amount', 'date', 'valuation', 'context', 'project_id'];
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
