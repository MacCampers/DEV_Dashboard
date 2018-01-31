<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('matches', function (Blueprint $table) {
         $table->uuid('id');
         
         $table->uuid('project_id');
         $table->integer('matchable_id')->unsigned();
         $table->string('matchable_type');

         $table->integer('score');
         $table->boolean('selected')->default(0);
         $table->boolean('viewed')->default(0);
         $table->boolean('accepted')->default(0);
         $table->boolean('declined')->default(0);
         $table->text('nda_text')->nullable();
         $table->boolean('nda_accepted_company')->default(0);
         $table->boolean('nda_accepted_strategy')->default(0);
         $table->boolean('nda_bypass')->default(0);
         $table->uuid('nda_id')->nullable();
         $table->uuid('loi_id')->nullable();
         $table->boolean('loi_accepted')->default(0);
         $table->uuid('binding_offer_id')->nullable();
         $table->boolean('binding_offer_accepted')->default(0);
         $table->integer('strategy_signatory_id')->unsigned()->nullable();
         $table->timestamp('ended_at')->nullable();
         $table->string('ended_by', 20)->nullable();
         $table->text('end_comment')->nullable();
         $table->timestamp('last_email')->nullable();
         $table->string('export_uri')->nullable();
         $table->timestamp('export_date')->nullable();

         $table->timestamps();

         $table->primary('id');

         $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
         $table->foreign('nda_id')->references('id')->on('documents')->onDelete('set null');
         $table->foreign('loi_id')->references('id')->on('documents')->onDelete('set null');
         $table->foreign('binding_offer_id')->references('id')->on('documents')->onDelete('set null');
         $table->foreign('strategy_signatory_id')->references('id')->on('users')->onDelete('set null');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('matches');
   }
}
