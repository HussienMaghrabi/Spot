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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->longText('desc');
            $table->string('code')->nullable();
            $table->string('verify')->nullable();
            $table->integer('curr_exp')->nullable()->default('0');
            $table->integer('karizma_exp')->nullable()->default('0');
            $table->integer('coins')->nullable()->default('0');
            $table->integer('gems')->nullable()->default('0');
            $table->string('user_level')->nullable()->default('1');
            $table->string('karizma_level')->nullable()->default('1');
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->date('date_joined')->nullable();
            $table->string('profile_pic')->nullable();
            $table->bigInteger('vip_role')->unsigned()->nullable()->default(null);
            $table->date('date_vip')->nullable()->default(null);
            $table->foreign('vip_role')->references('id')->on('vip_tiers')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
