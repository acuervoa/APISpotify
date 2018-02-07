<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_profiles', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('nick');
            $table->string('email');
            $table->string('display_name');
            $table->string('country');
            $table->string('href');
            $table->string('image_url');
            $table->string('accessToken');
            $table->string('refreshToken');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spotify_profiles');
    }
}
