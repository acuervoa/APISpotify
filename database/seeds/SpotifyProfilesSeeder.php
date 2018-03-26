<?php

use Illuminate\Database\Seeder;

class SpotifyProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($j=1; $j<=10;$j++) {

            $profile = factory(\App\SpotifyProfile::class)->create();

            $max = random_int(1, 10);
            for ($x = 1; $x < $max; $x++) {
                $track = factory(\App\Track::class)->create();
                $artist = factory(\App\Artist::class)->create();

                $track->artists()->attach($artist->artist_id);
                $profile->tracks()->attach($track->track_id, ['played_at' => \Carbon\Carbon::now()]);

            }
        }

        $albums = \App\Album::all();

        foreach ($albums as $a_album) {
            $artist = \App\Artist::inRandomOrder()->first()->get();
            $a_album->artists()->attach($artist);
        }
    }
}
