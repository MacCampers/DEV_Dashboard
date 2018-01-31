<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevelopmentStagesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('development_stages', function (Blueprint $table) {
         $table->increments('id');
         $table->string('code');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('development_stages');
   }
}
