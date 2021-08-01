<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('badge_parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('image');
            $table->bigInteger('badge_categoryId')->unsigned();
            $table->timestamps();
            $table->foreign('badge_categoryId')->references('id')->on('badges_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('badge_parents');
    }
}
