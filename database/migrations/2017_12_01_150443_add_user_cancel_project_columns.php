<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserCancelProjectColumns extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::table('projects', function (Blueprint $table) {
         $table->boolean('stopped')->nullable()->after('canceled');
         $table->text('cancel_comment')->nullable()->after('stopped');
         $table->string('cancel_purpose')->nullable()->after('cancel_comment');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::table('projects', function (Blueprint $table) {
         $table->dropColumn(['stopped', 'cancel_comment', 'cancel_purpose']);
      });
   }
}
