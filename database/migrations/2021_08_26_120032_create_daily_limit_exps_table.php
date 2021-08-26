<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyLimitExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_limit_exps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mic_exp_max')->default(180);
            $table->integer('mic_exp_val')->default(3);
            $table->integer('follow_exp_max')->default(20);
            $table->integer('follow_exp_val')->default(2);
            $table->integer('gift_send_max')->default(500);
            $table->integer('gift_receive_max')->default(500);
            $table->integer('login_max')->default(20);
            $table->integer('charge_val')->default(50);
            $table->integer('gift_val')->default(30);
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
        Schema::dropIfExists('daily_limit_exps');
    }
}
