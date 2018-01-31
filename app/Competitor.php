<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model {

   protected $table = 'competitors';
   protected $fillable = ['name', 'turnover', 'description', 'project_id'];
   public $timestamps = false;

}
