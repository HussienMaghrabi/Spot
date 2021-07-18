<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('img_link')->nullable();
            $table->integer('amount')->nullable();
            $table->longText('description')->nullable();
            $table->bigInteger('gift_id')->nullable()->unsigned();
            $table->integer('category_id');
            $table->bigInteger('badgeCategory_id')->unsigned();
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('cascade');
            $table->foreign('badgeCategory_id')->references('id')->on('badges_categories')->onDelete('cascade');
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
        Schema::dropIfExists('badges');
    }
}
