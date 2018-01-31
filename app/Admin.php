<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {

   protected $table = 'admins';

   protected $fillable = ['last_connection'];
   protected $hidden = ['password'];

   // Get user's full name
   public function getFullName() {
      return $this->firstname.' '.$this->lastname;
   }

}
