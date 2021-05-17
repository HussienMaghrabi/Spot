<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sender')->unsigned();
            $table->foreign('sender')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('reciever')->unsigned();
            $table->foreign('reciever')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('gift_id')->unsigned();
            $table->foreign('gift_id')->references('id')->on('items')->onDelete('cascade');
            $table->dateTime('date_sent');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
