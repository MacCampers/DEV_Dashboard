<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('messages', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('match_id');
         $table->string('sender', 20);
         $table->integer('user_id')->unsigned();
         $table->text('content')->nullable();
         $table->boolean('read');
         
         $table->timestamps();

         $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      });

      Schema::create('message_attachments', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('message_id')->unsigned();
         $table->uuid('document_id');

         $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
         $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('message_attachments');
      Schema::dropIfExists('messages');
   }
}
