<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoiRequirementsTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('loi_requirements', function (Blueprint $table) {
         $table->increments('id');
         $table->string('code');
         $table->integer('parent')->unsigned()->nullable();

         $table->foreign('parent')->references('id')->on('loi_requirements')->onDelete('cascade');
      });

      // Synthesis - Loi Requirement
      Schema::create('project_loi_requirement', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('project_id');
         $table->integer('loi_requirement_id')->unsigned();

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('loi_requirement_id')->references('id')->on('loi_requirements')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('project_loi_requirement');
      Schema::dropIfExists('loi_requirements');
   }
}
