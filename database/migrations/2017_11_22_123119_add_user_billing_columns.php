<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserBillingColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->string('billing_company_name', 110)->nullable()->after('subscription_ends_at');
            $table->string('billing_name', 60)->nullable()->after('billing_company_name');
            $table->string('billing_address_1')->nullable()->after('billing_name');
            $table->string('billing_address_2')->nullable()->after('billing_address_1');
            $table->string('billing_city', 80)->nullable()->after('billing_address_2');
            $table->string('billing_zipcode', 10)->nullable()->after('billing_city');
            $table->integer('billing_country_id')->nullable()->unsigned()->after('billing_zipcode');

            $table->foreign('billing_country_id')->references('id')->on('zones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
      Schema::table('users', function (Blueprint $table) {
         $table->dropForeign('users_billing_country_id_foreign');
         $table->dropColumn(['billing_company_name', 'billing_name', 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_zipcode', 'billing_country_id']);
      });
    }
}
