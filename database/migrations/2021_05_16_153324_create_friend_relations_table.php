<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_relations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_1')->unsigned();
            $table->foreign('user_1')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('user_2')->unsigned();
            $table->foreign('user_2')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_added');
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
        Schema::dropIfExists('friend_relations');
    }
}
