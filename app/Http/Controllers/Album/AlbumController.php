<?php

namespace App\Http\Controllers\Album;


use App\Album;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AlbumController extends Controller
{

    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopReproductionsAlbums($limit)
    {

        $tracksByAlbum = DB::table('profile_tracks')
            ->join('tracks', 'profile_tracks.track_id', '=', 'tracks.track_id')
            ->select('profile_tracks.track_id', 'tracks.album_id');

        $results = DB::table(DB::raw("(" . $tracksByAlbum->toSql() .") as tracksByAlbum" ))
            ->mergeBindings($tracksByAlbum)
            ->select('album_id', DB::raw('count(*) as total'))
            ->distinct()
            ->groupBy('album_id')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();


        return $results->pluck('total', 'album_id')->all();
    }



    public static function getAlbumsInfo($album_ids) {
         return self::getAlbumsCompleteData($album_ids);
    }


    public static function getAlbumsRanking($limit): array
    {
        return [];
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
            $album = Album::find($album_id);

            if (empty($album->name) || empty($album->image_url_640x640)) {
               $infoAlbum = Album::getSpotifyData($album_id);

               $album = Album::updateOrCreate(['album_id' => $album_id], [
                    'name' => $infoAlbum->name,
                    'image_url_640x640' => $infoAlbum->images[0]->url,
                    'image_url_300x300' => $infoAlbum->images[1]->url,
                    'image_url_64x64' => $infoAlbum->images[2]->url,
                    'link_to' => $infoAlbum->href
                ]);
            }

            $album->reproductions = $reproductions;
            $response[] = $album;
        }

        return $response;
    }

}
