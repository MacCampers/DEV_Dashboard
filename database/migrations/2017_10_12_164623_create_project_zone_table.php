<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectZoneTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('project_zone', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('project_id');
         $table->integer('zone_id')->unsigned();

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('project_zone');
   }
}
