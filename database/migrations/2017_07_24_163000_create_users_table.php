<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('users', function (Blueprint $table) {
         $table->increments('id');

         $table->string('type');

         $table->string('title', 5);
         $table->string('first_name', 60);
         $table->string('last_name', 60);
         $table->string('email')->unique();
         $table->string('phone_fixed', 25)->nullable();
         $table->string('phone_mobile', 25)->nullable();
         $table->string('password')->nullable();
         $table->date('birth_date')->nullable();
         $table->string('job')->nullable();
         $table->string('linkedin_url')->nullable();
         $table->string('viadeo_url')->nullable();

         $table->integer('company_id')->unsigned()->nullable();
         $table->string('company_role')->nullable();

         $table->string('payment_method')->nullable();
         $table->string('iban')->nullable();
         $table->string('iban_owner')->nullable();

         $table->string('stripe_id')->nullable();
         $table->string('card_last_four', 4)->nullable();
         $table->string('card_brand')->nullable();
         $table->timestamp('trial_ends_at')->nullable();
         $table->timestamp('subscription_ends_at')->nullable();

         $table->string('default_language', 5);
         $table->string('activation_code')->nullable();
         $table->string('password_creation_token', 100)->nullable();
         $table->boolean('confirmed')->default(0);

         $table->string('source')->nullable();

         $table->rememberToken();
         $table->timestamps();
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('users');
   }
}
