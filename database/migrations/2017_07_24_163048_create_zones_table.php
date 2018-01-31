<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZonesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('zones', function (Blueprint $table) {
         $table->increments('id');
         $table->string('type', 20);
         $table->string('code', 30);
         $table->integer('parent')->unsigned()->nullable();

         $table->foreign('parent')->references('id')->on('zones')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('zones');
   }
}
