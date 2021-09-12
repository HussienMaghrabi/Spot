<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('special_id')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token')->nullable()->unique();
            $table->string('mobile_id')->nullable();
            $table->string('socket_id')->nullable();
            $table->date('birth_date')->nullable();
            $table->longText('desc')->nullable();
            $table->string('code')->nullable();
            $table->string('verify')->nullable();
            $table->boolean('completed')->default(false);
            $table->integer('curr_exp')->nullable()->default('0');
            $table->integer('karizma_exp')->nullable()->default('0');
            $table->integer('coins')->nullable()->default('0');
            $table->integer('gems')->nullable()->default('0');
            $table->boolean('freeze_gems')->default(false);
            $table->string('user_level')->nullable()->default('1');
            $table->string('karizma_level')->nullable()->default('1');
            $table->string('gender')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->date('date_joined')->nullable();
            $table->string('profile_pic')->nullable();
            $table->bigInteger('vip_role')->unsigned()->nullable()->default(null);
            $table->date('date_vip')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('vip_role')->references('id')->on('vip_tiers')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('contries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
