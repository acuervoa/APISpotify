<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArtistRankingController extends Controller
{
    public static function getArtistRanking(int $limit)
    {
        return  self::getTopReproductionsArtist($limit);
    }


    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopReproductionsArtist(int $limit)
    {

        $artistByTracks = DB::table('artist_tracks')
            ->leftJoin('profile_tracks', 'profile_tracks.track_id', '=', 'artist_tracks.track_id')
            ->join('artists', 'artists.artist_id', '=', 'artist_tracks.artist_id')
            ->select('profile_tracks.track_id', 'artists.artist_id');

        $results = DB::table(DB::raw('(' . $artistByTracks->toSql() . ') as artistByTracks'))
            ->mergeBindings($artistByTracks)
            ->select('artist_id', DB::raw('count(*) as total'))
            ->groupBy('artist_id')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->get();


        return $results->pluck('artist_id')->all();
    }


    public static function sortArtistsByReproductions(array $artists): array
    {
        foreach ($artists as $a_artist) {
            $reproductions = ArtistController::getArtistReproductions($a_artist);
            $a_artist->reproductions = $reproductions->total;

            usort($artists, static function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }
        return $artists;
    }
}
