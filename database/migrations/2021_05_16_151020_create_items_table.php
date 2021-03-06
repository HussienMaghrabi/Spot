<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('img_link');
            $table->string('file');
            $table->integer('price');
            $table->string('type');
            $table->bigInteger('cat_id')->unsigned()->nullable();
            $table->integer('duration');
            $table->unsignedBigInteger('vip_item')->nullable();
            $table->timestamps();
            $table->foreign('cat_id')->references('id')->on('item_categories')->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
}
