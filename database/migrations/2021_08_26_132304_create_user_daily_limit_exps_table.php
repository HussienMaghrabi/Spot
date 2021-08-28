<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDailyLimitExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_daily_limit_exps', function (Blueprint $table) {
            $table->id();
            $table->integer('mic_exp')->nullable();
            $table->integer('follow_exp')->nullable();
            $table->integer('gift_send')->nullable();
            $table->integer('gift_receive')->nullable();
            $table->integer('login')->nullable();
            $table->integer('charge')->nullable();
            $table->integer('gift_coins')->nullable();
            $table->time('mic_start')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->date('last_day');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_daily_limit_exps');
    }
}
