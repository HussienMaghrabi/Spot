<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('agora_id');
            $table->bigInteger('room_owner')->unsigned()->unique();
            $table->string('lang')->nullable();
            $table->text('broadcast_message')->nullable();
            $table->text('password')->nullable();
            $table->text('main_image')->nullable();
            $table->text('background')->nullable();
            $table->integer('join_fees')->unsigned();
            $table->boolean('take_mic')->default(true);
            $table->boolean('pinned')->default(false);
            $table->boolean('send_image')->default(true);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('country_id')->nullable();

            $table->foreign('room_owner')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('contries')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->date('created_at');
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
