<?php

namespace App\Http\Controllers\Album;


use App\Album;
use App\Http\Controllers\Artist\ArtistController;
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

        debug('tracksByAlbum', $tracksByAlbum->toSql());

        $other = DB::table(DB::raw("(" . $tracksByAlbum->toSql() .") as tracksByAlbum" ))
            ->mergeBindings($tracksByAlbum)
            ->select('album_id', DB::raw('count(*) as total'))
            ->distinct()
            ->groupBy('album_id')
            ->orderBy('total', 'desc')
            ->limit($limit);

        debug('other', $other->toSql());

        $results = $other->get();

        return $results->pluck('album_id')->all();
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
    public static function fillAlbumsData(array $albums): array
    {

        debug('albums', $albums);

        $response = [];

        foreach ($albums as $album_id) {
            $album = Album::find($album_id);

            if (empty($album->link_to)) {
               $infoAlbum = Album::getSpotifyData($album_id);

               $images = [
                   'image_url_640x640' => array_key_exists(0, $infoAlbum->images) ?? $infoAlbum->images[0]->url,
                   'image_url_300x300' => array_key_exists(1, $infoAlbum->images) ?? $infoAlbum->images[1]->url,
                   'image_url_64x64' => array_key_exists(2, $infoAlbum->images) ?? $infoAlbum->images[2]->url
               ];
               $album = Album::updateOrCreate(['album_id' => $album_id], [
                    'name' => $infoAlbum->name,
                    $images,
                    'link_to' => $infoAlbum->href
                ]);

            }


            $response[] = $album->load('artists');
        }

        return $response;
    }


    private static function sortAlbumsByReproductions(array $albums)
    {
        foreach ($albums as $a_album) {

            $reproductions = self::getAlbumReproductions($a_album);
            $a_album->reproductions = $reproductions->total;

            usort($albums, function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }
        return $albums;
    }

    public static function getAlbumsCompleteData($albums_ranking_ids)
    {
        return self::sortAlbumsByReproductions(self::fillAlbumsData($albums_ranking_ids));

    }

    public static function getAlbumReproductions(Album $a_album)
    {

    }

}
