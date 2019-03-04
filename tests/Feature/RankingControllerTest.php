<?php
/**
 * Created by PhpStorm.
 * User: andres.cuervo.adame
 * Date: 2019-03-04
 * Time: 17:05
 */

namespace Tests\Feature;

use App\Http\Controllers\Ranking\RankingController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RankingControllerTest extends TestCase
{
    use DatabaseMigrations;

    /* @test */
    public function test_get_track_ranking() {


        $profiles = factory(\App\SpotifyProfile::class, 5)->create();
        $tracks = factory(\App\Track::class, 100)->create();

        foreach($tracks as $track) {

            $track->profiles()->save($profiles[mt_rand(0,4)], ['played_at' => Carbon::now()]);

        }

        $values = RankingController::getTracksRanking(5);

        dd($values);

        $this->assertTrue(true);
    }

}
