<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->string('artist_id')->unique();
            $table->string('name');
            $table->string('image_url_640x640')->nullable();
            $table->string('image_url_320x320')->nullable();
            $table->string('image_url_160x160')->nullable();
            $table->string('link_to')->nullable();
            $table->timestamps();

            $table->primary('artist_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artists');
    }
}
