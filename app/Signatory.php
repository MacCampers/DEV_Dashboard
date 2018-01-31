<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Signatory extends Model {

   protected $table = 'signatories';
   protected $fillable = ['document_id', 'user_id', 'email', 'phone', 'yousign_token', 'yousign_id_demand', 'yousign_id_file', 'status', 'signature_page', 'signature_position', 'signed_at'];

   public $timestamps = false;
   public $incrementing = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function user() {
      return $this->belongsTo('App\User', 'user_id');
   }

   public function document() {
      return $this->belongsTo('App\Document', 'document_id');
   }


   /*
   |--------------------------------------------------------------------------
   | Getters
   |--------------------------------------------------------------------------
   */
   public function getSignatureDateTime() {
      if( $this->signed_at ) {
         $dt = Carbon::parse($this->signed_at);
         return ['date' => $dt->format('d/m/Y'), 'time' => $dt->format('H:i')];
      }

      return ['date' => null, 'time' => null];
   }

}
