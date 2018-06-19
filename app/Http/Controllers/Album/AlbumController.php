<?php

namespace App\Http\Controllers\Album;

use App\Album;
use App\Artist;
use Carbon\Carbon;

use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SpotifyWebAPI\SpotifyWebAPI;

class AlbumController extends Controller
{

    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopReproductionsAlbums($limit)
    {
        $results = DB::table('albums')
            ->select('albums.album_id', 'results.total')
            ->join(DB::raw(' 
                    (
                        select album_id, count(*) as total from tracks where track_id 
                        in (select track_id from profile_tracks)
                        group by album_id
                        order by total desc) as results'),

                function ($join) {
                    $join->on('albums.album_id', '=', 'results.album_id');
                }
            )->orderBy('total', 'desc')
            ->orderBy('album_id', 'desc')
            ->take($limit)
            ->get();

        return $results->pluck('total', 'album_id')->all();
    }


    public static function getAlbumsRanking($limit): array
    {
        return self::fillAlbumsData(self::getTopReproductionsAlbums($limit));
    }

    /**
     * Get top albums from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getAlbumsRankingLastDay($limit): array
    {

        $results =  $results = DB::table('albums')
            ->select('albums.*', 'results.total')
            ->join(DB::raw(' 
                    (
                        select album_id, count(*) as total from tracks where track_id 
                        in (select track_id from profile_tracks where played_at >=\''. Carbon::now()->subDay() . '\' )
                        group by album_id
                        order by total desc) as results'),

                function ($join) {
                    $join->on('albums.album_id', '=', 'results.album_id');
                }
            )->orderBy('total', 'desc')
            ->orderBy('album_id', 'desc')
            ->take($limit)
            ->get();

        return $results->pluck('album_id')->all();
    }

    /**
     * @param $albums
     * @return array
     */
    private static function fillAlbumsData(array $albums): array
    {
        $response = [];

        foreach ($albums as $album_id => $reproductions) {
            $album = Album::find($album_id)->get();

            if (null === $album->image_url_640x640) {
                $infoAlbum = Album::getSpotifyData($album_id);

                $album->name = $infoAlbum->name;
                $album->image_url_640x640 = $infoAlbum->images[0]->url;
                $album->image_url_300x300 = $infoAlbum->images[1]->url;
                $album->image_url_64x64 = $infoAlbum->images[2]->url;
                $album->link_to = $infoAlbum->linkTo;

                $album->save();
            }

            $album->reproductions = $reproductions;
            $response[] = $album;
        }
        return $response;
    }

}
