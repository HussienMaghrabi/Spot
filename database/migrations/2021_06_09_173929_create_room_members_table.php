<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('room_id')->unsigned();
            $table->json('follow_user')->nullable();
            $table->json('join_user')->nullable();
            $table->json('active_user')->nullable();
            $table->json('ban_enter')->nullable();
            $table->json('ban_chat')->nullable();
            $table->json('on_mic')->nullable();
            $table->json('admins')->nullable();
            $table->integer('active_count')->default(0);
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_members');
    }
}
