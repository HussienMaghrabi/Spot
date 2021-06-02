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
            $table->integer('curr_exp')->nullable();
            $table->integer('coins')->nullable();
            $table->integer('gems')->nullable();
            $table->string('user_level')->nullable();
            $table->string('karizma_level')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->date('date_joined')->nullable();
            $table->string('profile_pic')->nullable();
            $table->rememberToken();
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
