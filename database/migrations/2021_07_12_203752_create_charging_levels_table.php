<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargingLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charging_levels', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('level_limit');
            $table->string('desc')->nullable();
            $table->json('gift_id')->nullable();
            $table->unsignedBigInteger('badge_id');
            $table->unsignedBigInteger('levelNo');
            $table->timestamps();
            $table->foreign('badge_id')->references('id')->on('badges')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charging_levels');
    }
}
