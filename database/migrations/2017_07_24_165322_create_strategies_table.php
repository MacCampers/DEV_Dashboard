<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrategiesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('strategies', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name', 80);

         $table->integer('company_id')->unsigned();

         $table->integer('value_min')->nullable();
         $table->integer('value_max')->nullable();
         $table->integer('amount_min')->nullable();
         $table->integer('amount_max')->nullable();
         $table->integer('revenues_min')->nullable();
         $table->integer('revenues_max')->nullable();
         $table->integer('value_min_equiteasy')->nullable();
         $table->integer('value_max_equiteasy')->nullable();
         $table->integer('amount_min_equiteasy')->nullable();
         $table->integer('amount_max_equiteasy')->nullable();
         $table->integer('revenues_min_equiteasy')->nullable();
         $table->integer('revenues_max_equiteasy')->nullable();

         $table->boolean('majority')->nullable();
         $table->boolean('minority')->nullable();
         $table->boolean('profitable')->nullable();
         $table->boolean('social_impact')->nullable();

         $table->string('company_size', 20);
         $table->boolean('mbi')->nullable();

         $table->text('notes')->nullable();

         $table->boolean('confirmed');
         $table->timestamps();

         $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
      });

      Schema::create('strategy_development_stage', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('strategy_id')->unsigned();
         $table->integer('development_stage_id')->unsigned();

         $table->foreign('strategy_id')->references('id')->on('strategies')->onDelete('cascade');
         $table->foreign('development_stage_id')->references('id')->on('development_stages')->onDelete('cascade');
      });

      Schema::create('strategy_activity_area', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('strategy_id')->unsigned();
         $table->integer('activity_area_id')->unsigned();
         $table->string('type', 30)->nullable();
         $table->float('weight')->nullable();

         $table->foreign('strategy_id')->references('id')->on('strategies')->onDelete('cascade');
         $table->foreign('activity_area_id')->references('id')->on('activity_areas')->onDelete('cascade');
      });

      Schema::create('strategy_zone', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('strategy_id')->unsigned();
         $table->integer('zone_id')->unsigned();
         $table->string('type', 30)->nullable();

         $table->foreign('strategy_id')->references('id')->on('strategies')->onDelete('cascade');
         $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
      });

      Schema::create('strategy_user', function (Blueprint $table) {
         $table->increments('id');
         $table->integer('strategy_id')->unsigned();
         $table->integer('user_id')->unsigned();

         $table->foreign('strategy_id')->references('id')->on('strategies')->onDelete('cascade');
         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('strategy_development_stage');
      Schema::dropIfExists('strategy_activity_area');
      Schema::dropIfExists('strategy_zone');
      Schema::dropIfExists('strategy_user');
      Schema::dropIfExists('strategies');
   }
}
