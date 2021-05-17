<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_1')->unsigned();
            $table->foreign('user_1')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('user_2')->unsigned();
            $table->foreign('user_2')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('follow_relations');
    }
}
