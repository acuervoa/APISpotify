<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->string('track_id')->unique();
            $table->string('name');
            $table->string('album_id');
            $table->string('preview_url')->nullable();
            $table->string('link_to')->nullable();
            $table->integer('duration_ms')->nullable();
            $table->timestamps();

            $table->primary('track_id');
            $table->index('album_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracks');
    }
}
