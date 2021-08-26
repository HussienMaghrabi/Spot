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
            $table->string('name');
            $table->string('img_link');
            $table->string('file')->default(" ");
            $table->integer('price');
            $table->boolean('flag')->default(false);
            $table->unsignedBigInteger('vip_item')->nullable();
            $table->timestamps();
            $table->foreign('vip_item')->references('id')->on('vip_tiers')->onDelete('cascade');
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
