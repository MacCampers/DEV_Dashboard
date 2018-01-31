<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityAreasTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('activity_areas', function (Blueprint $table) {
         $table->increments('id');
         $table->string('code');
         $table->integer('parent')->unsigned()->nullable();

         $table->foreign('parent')->references('id')->on('activity_areas')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('activity_areas');
   }
}
