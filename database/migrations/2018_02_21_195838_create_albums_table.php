<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->string('album_id')->unique();
            $table->string('name');
            $table->string('image_url_640x640')->nullable();
            $table->string('image_url_300x300')->nullable();
            $table->string('image_url_64x64')->nullable();
            $table->string('link_to')->nullable();
            $table->timestamps();

            $table->primary('album_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
