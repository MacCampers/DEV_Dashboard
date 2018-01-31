<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::table('documents', function (Blueprint $table) {
         $table->dropColumn('comment');
      });

      Schema::create('offers', function (Blueprint $table) {
         $table->increments('id');
         $table->uuid('match_id');
         $table->uuid('document_id');
         $table->string('type', 20);
         $table->text('owner_comment')->nullable();
         $table->text('recipient_comment')->nullable();
         $table->boolean('declined')->default(0);

         $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
         $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::table('documents', function (Blueprint $table) {
         $table->text('comment')->nullable()->after('signed');
      });

      Schema::dropIfExists('offers');
   }
}
