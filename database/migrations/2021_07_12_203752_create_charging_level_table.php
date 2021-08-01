<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_level', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('level_limit');
            $table->unsignedBigInteger('gift_id')->nullable();
            $table->unsignedBigInteger('levelNo');
            $table->timestamps();
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charging_level');
    }
}
