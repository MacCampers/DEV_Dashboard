<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('companies', function (Blueprint $table) {
         $table->increments('id');
         $table->string('name', 80);
         $table->string('type', 20);
         $table->string('category', 40)->nullable();
         $table->string('registration_number', 50)->nullable();
         $table->string('address_1')->nullable();
         $table->string('address_2')->nullable();
         $table->string('zipcode', 10)->nullable();
         $table->string('city', 80)->nullable();
         $table->integer('country_id')->unsigned()->nullable();
         $table->integer('region_id')->unsigned()->nullable();
         $table->string('email')->nullable();
         $table->string('phone', 25)->nullable();
         $table->string('website')->nullable();
         $table->integer('deals_per_year')->nullable();
         $table->boolean('confirmed');
         $table->timestamps();

         $table->foreign('country_id')->references('id')->on('zones')->onDelete('set null');
         $table->foreign('region_id')->references('id')->on('zones')->onDelete('set null');
      });

      Schema::table('users', function (Blueprint $table) {
         $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::table('users', function (Blueprint $table) {
         $table->dropForeign('users_company_id_foreign');
      });

      Schema::dropIfExists('companies');
   }
}
