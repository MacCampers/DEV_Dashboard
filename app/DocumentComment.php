<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DocumentComment extends Model {

   protected $table = 'document_comments';
   protected $fillable = ['id', 'document_id', 'comment'];

   public $incrementing = true;
   public $timestamps = false;
   

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function documents() {
      return $this->belongsTo('App\Document', 'document_id');
   }

}
