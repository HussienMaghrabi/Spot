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
            $table->unsignedBigInteger('gift_id')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
<<<<<<< HEAD
            $table->unsignedInteger('coins');
=======
            $table->unsignedInteger('coins')->nullable();
>>>>>>> f8e8a8aff8e211ad32980d2bcf893eaac6c36f43
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
