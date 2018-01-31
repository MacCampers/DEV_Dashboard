<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {
   /**
   * Run the migrations.
   *
   * @return void
   */
   public function up() {
      Schema::create('invoices', function (Blueprint $table) {
         $table->string('id');
         $table->integer('user_id')->unsigned()->nullable();
         $table->string('stripe_invoice_id');
         $table->string('uri')->nullable();
         $table->float('amount')->nullable();;
         $table->timestamp('date')->nullable();;

         $table->timestamps();

         $table->primary('id');

         $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      });
   }

   /**
   * Reverse the migrations.
   *
   * @return void
   */
   public function down() {
      Schema::dropIfExists('invoices');
   }
}
