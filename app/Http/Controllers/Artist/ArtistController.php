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

        $artistByTracks = DB::table('artist_tracks')
            ->leftJoin('profile_tracks', 'profile_tracks.track_id', '=', 'artist_tracks.track_id' )
            ->join('artists', 'artists.artist_id', '=', 'artist_tracks.artist_id')
            ->select('profile_tracks.track_id', 'artists.artist_id');

        $results = DB::table(DB::raw("(" . $artistByTracks->toSql() . ") as artistByTracks"))
            ->mergeBindings($artistByTracks)
            ->select('artist_id', DB::raw('count(*) as total'))
            ->groupBy('artist_id')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();


        return $results->pluck('total', 'artist_id')->all();

    }


    public static function getArtistRanking($limit) {

        $artists = self::getTopReproductionsArtist($limit);
        $response = [];

        foreach ((array) $artists as $artist_id => $reproductions){

            $artist = Artist::find($artist_id);

            if (empty($artist->name)  || empty($artist->image_url_320x320)) {
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
