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
        Schema::create('clothesusers', function (Blueprint $table) {
            $table->id(); $table->string('code');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('clothes_id');
            $table->boolean('buy')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('clothes_id')->references('id')->on('clothes');
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
        Schema::dropIfExists('clothesusers');
    }
};
