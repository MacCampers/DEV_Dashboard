<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTextFieldsTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('text_fields', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('project_id');
         $table->string('field');
         $table->text('value')->nullable();

         $table->unique(['project_id', 'field']);

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('text_fields');
   }
}
