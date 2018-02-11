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
            $table->uuid('id')->unique();
            $table->string('nick');
            $table->string('email');
            $table->string('display_name')->nullable();
            $table->string('country')->nullable();
            $table->string('href')->nullable();
            $table->string('image_url')->nullable();
            $table->string('accessToken');
            $table->string('refreshToken');
            $table->string('expirationToken');

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
