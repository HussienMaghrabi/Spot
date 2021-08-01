<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsPurchasedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins_purchaseds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->integer('amount');
            $table->date('date_of_purchase');
            $table->bigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins_purchaseds');
    }
}
