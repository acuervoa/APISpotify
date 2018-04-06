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


    public static function getAlbumsRanking($limit)
    {
       $albums = self::getTopReproductionsAlbums($limit);
       $response = [];

       foreach((array) $albums as $album_id => $reproductions) {
           $album = Album::find($album_id)->load('artists');

           if(!$album->image_url_640x640){
               $infoAlbum = Album::getAlbumCompleteData($album_id);

               $album->image_url_640x640 = $infoAlbum->images[0]->url;
               $album->image_url_300x300 = $infoAlbum->images[1]->url;
               $album->image_url_64x64 = $infoAlbum->images[2]->url;
               $album->save();
           }

           $album->reproductions = $reproductions;
           $response[] = $album;
       }

       return $response;
    }

    /**
     * Get top albums from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getAlbumsRankingLastDay($limit)
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


//        $albums = DB::table('tracks')
//            ->select('album_id', DB::raw('count(*) as total'))
//            ->where('played_at', '>=', Carbon::now()->subDay())
//            ->groupBy('album_id')
//            ->orderBy('total', 'desc')
//            ->orderBy('album_id', 'desc')
//            ->take($limit)
//            ->get();

        return $results->pluck('album_id')->all();
    }

}
