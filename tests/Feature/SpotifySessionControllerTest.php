<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SpotifySessionControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function db_have_10_users()
    {
        factory(\App\SpotifyProfile::class,10)->create();

        $this->assertEquals(10, \App\SpotifyProfile::count());
    }

    /** @test */
    public function a_guess_can_access_to_index_with_database_empty() {

        $response = $this->get(url('/'));
        $response->assertStatus(200);
    }

    /** @test */
    public function a_guess_can_access_to_index_with_values_in_database(){

        $tracks = factory(\App\Track::class,200)->create();
        $album = \App\Album::find($tracks[0]->album_id);
        $artists = $album->artists();

        $response = $this->get(url('/'));
        $response->assertStatus(200);

        foreach ($artists as $artist) {
            var_dump($artist);
        }

    }
}
