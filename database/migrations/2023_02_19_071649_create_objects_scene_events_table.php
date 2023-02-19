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
        Schema::create('objects_scene_events', function (Blueprint $table) {
            $table->id(); $table->string('code');
            $table->unsignedBigInteger('events_id')->nullable();
            $table->unsignedBigInteger('objects_scenes_id');
            $table->boolean('buy')->default(0);
            $table->foreign('events_id')->references('id')->on('events');
            $table->foreign('objects_scenes_id')->references('id')->on('objects_scenes');
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
        Schema::dropIfExists('objects_scene_events');
    }
};
