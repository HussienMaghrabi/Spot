<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('desc');
            $table->text('image')->nullable();
            $table->integer('coin_fees');
            $table->integer('duration');
            $table->date('date');
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('image_id')->references('id')->on('activity_images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
