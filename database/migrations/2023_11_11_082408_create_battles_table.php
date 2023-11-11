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
        Schema::create('battleusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('battle_id');
            $table->decimal('value', 10, 2);
            $table->boolean('paid')->default(false);
            $table->string('code', 4)->unique();
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->foreign('battle_id')->references('id')->on('battles')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('battles');
    }
};
