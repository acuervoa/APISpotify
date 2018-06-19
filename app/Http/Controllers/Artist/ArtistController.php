<?php

namespace App\Http\Controllers\Artist;

use App\Artist;
use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class ArtistController extends Controller
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopReproductionsArtist($limit) {


        $results = DB::table('artists')
            ->select('artists.artist_id',  'results.total')
            ->join(DB::raw(' 
                    (
                    select artist_tracks.artist_id, count(*) as total from artist_tracks where track_id in 
                        (
                            select track_id from tracks where track_id in
                            (
                                select track_id from profile_tracks
                            )
                        )
                    group by artist_id
                    order by total desc
                    )
                    as results'),
                    function ($join) {
                         $join->on('artists.artist_id', '=', 'results.artist_id');
                    }
            )->take($limit)
            ->orderBy('total', 'desc')
            ->orderBy('artist_id', 'desc')
            ->get();

        return $results->pluck('total', 'artist_id')->all();

    }


    public static function getArtistRanking($limit) {

        $artists = self::getTopReproductionsArtist($limit);
        $response = [];

        foreach ((array) $artists as $artist_id => $reproductions){

            $artist = Artist::find($artist_id);

            if (null === $artist->image_url_320x320) {
                $infoArtist = Artist::getSpotifyData($artist_id);

                $artist = Artist::updateOrCreate(['artist_id' => $artist_id],
                    [
                        'name' => $infoArtist->name,
                        'image_url_640x640' => $infoArtist->images[0]->url,
                        'image_url_320x320' => $infoArtist->images[1]->url,
                        'image_url_160x160' => $infoArtist->images[2]->url,
                        'link_to' => $infoArtist->href,
                    ]);
            }

            $artist->reproductions = $reproductions;

            $response[] = $artist;
        }


        return $response;
    }


}
