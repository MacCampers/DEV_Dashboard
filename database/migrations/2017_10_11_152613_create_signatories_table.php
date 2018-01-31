<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignatoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('signatories', function(Blueprint $table) {
            $table->uuid('id');
            $table->uuid('document_id');
            $table->integer('user_id')->unsigned();
            $table->string('email');
            $table->string('phone');
            $table->string('yousign_token');
            $table->integer('yousign_id_demand');
            $table->integer('yousign_id_file');
            $table->string('status', 30);

            $table->tinyInteger('signature_page')->nullable();
            $table->string('signature_position', 20)->nullable();
            $table->timestamp('signed_at')->nullable();

            $table->primary('id');

            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('signatories');
    }
}
