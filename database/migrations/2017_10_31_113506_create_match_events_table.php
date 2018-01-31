<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchEventsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('match_events', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('match_id');
            $table->string('description');
            $table->string('initiator', 20)->nullable();
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('match_events');
    }
}
