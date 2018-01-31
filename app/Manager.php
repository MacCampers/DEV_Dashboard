<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model {

   protected $table = 'managers';
   protected $fillable = ['name', 'position', 'description', 'url', 'resume_id', 'project_id'];
   public $timestamps = false;

   /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */
   public function resume() {
      return $this->belongsTo('App\Document', 'resume_id');
   }

}
