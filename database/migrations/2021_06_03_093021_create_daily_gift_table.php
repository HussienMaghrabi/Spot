<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyGiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_gift', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('image_link')->nullable();
            $table->unsignedBigInteger('gift_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedInteger('coins');
            $table->timestamps();

            $table->foreign('gift_id')->references('id')->on('gifts');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_gift');
    }
}
