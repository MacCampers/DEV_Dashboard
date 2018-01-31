<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model {

   protected $table = 'offers';
   protected $fillable = ['match_id', 'document_id', 'type', 'owner_comment', 'recipient_comment', 'declined'];

   public $timestamps = false;
   public $with = ['document'];

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function match() {
      return $this->belongsTo('App\Match', 'match_id');
   }

   public function document() {
      return $this->belongsTo('App\Document', 'document_id');
   }

}
