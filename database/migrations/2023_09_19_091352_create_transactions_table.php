<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->unsignedBigInteger('user_id')->required();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->string('invoice')->unique();
            $table->timestamp('date');
            $table->integer('total');
            $table->integer('paid');
            $table->integer('return');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
