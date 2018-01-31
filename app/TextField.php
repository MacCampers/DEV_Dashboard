<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextField extends Model {

   protected $table = 'text_fields';
   protected $fillable = ['project_id', 'field', 'value'];

   public $timestamps = false;

}
