<?php

use Illuminate\Database\Seeder;

class TracksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Track::class, 100)->create()->each(function($track){

            $track->album_id = factory(\App\Album::class)->make()->each(function ($album) {
                $album->genres()->save(factory(\App\Genre::class, random_int(1, 7))->make());
            })->id;

            $track->profiles()->save(factory(\App\SpotifyProfile::class, random_int(1, 3))->make());
            $track->artists()->save(factory(\App\Artist::class, random_int(1,4))->make());
        });
    }
}
