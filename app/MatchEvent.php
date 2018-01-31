<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchEvent extends Model {

   protected $table = 'match_events';
   protected $fillable = ['match_id', 'description', 'initiator'];
   public $with = ['match'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function match() {
      return $this->belongsTo('App\Match', 'match_id');
   }


   /*
   |--------------------------------------------------------------------------
   | Attributes
   |--------------------------------------------------------------------------
   */

   public function getDateAttribute() {
      return date('d/m/Y - H:i:s', strtotime($this->created_at));
   }

   public function getInitiatorAttribute($initiator) {
      if( $initiator === 'strategy' ) {
         return $this->match->matchable->full_name;
      } else {
         return $this->match->project->company_name;
      }
   }

}
