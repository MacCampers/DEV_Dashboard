<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shareholder extends Model {

   protected $table = 'shareholders';
   protected $fillable = ['name', 'security_type_1', 'security_number_1', 'security_type_2', 'security_number_2', 'security_type_3', 'security_number_3', 'project_id'];
   public $timestamps = false;
}
