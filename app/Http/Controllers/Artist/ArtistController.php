<?php

namespace App\Http\Controllers\Artist;

use App\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArtistController extends Controller
{


    public static function fillArtistsInfo(array $artists)
    {
        $response = [];

        foreach ($artists as $a_artist) {
            $artist = Artist::find($a_artist);
            if (empty($artist->link_to)) {

                $infoArtist = Artist::getSpotifyData($a_artist);
                $images = [];

                if (sizeof($infoArtist->images) > 0) {
                    $images = [
                        'image_url_640x640' => array_key_exists(0, $infoArtist->images[0]) ?? $infoArtist->images[0]->url,
                        'image_url_320x320' => array_key_exists(1, $infoArtist->images[1]) ?? $infoArtist->images[1]->url,
                        'image_url_64x64' => array_key_exists(2, $infoArtist->images[2]) ?? $infoArtist->images[2]->url,
                    ];
                }


                $artist = Artist::updateOrCreate(['artist_id' => $artist->artist_id], [
                    'name' => $infoArtist->name,
                    $images,
                    'link_to' => $infoArtist->href
                ]);

            }

            $response[] = $artist;
        }

        return $response;
    }

    public static function getArtistsCompleteData(array $artists_ranking_ids)
    {
        return ArtistRankingController::sortArtistsByReproductions(self::fillArtistsInfo($artists_ranking_ids));

    }

    public static function getArtistReproductions(Artist $a_artist)
    {
        $artistByTracks = DB::table('artist_tracks')
            ->leftJoin('profile_tracks', 'profile_tracks.track_id', '=', 'artist_tracks.track_id')
            ->join('artists', 'artists.artist_id', '=', 'artist_tracks.artist_id')
            ->select('profile_tracks.track_id', 'artists.artist_id')
            ->where('artists.artist_id', $a_artist->artist_id);

        return DB::table(DB::raw("(" . $artistByTracks->toSql() . ") as artistByTracks"))
            ->mergeBindings($artistByTracks)
            ->select('artist_id', DB::raw('count(*) as total'))
            ->groupBy('artist_id')
            ->orderBy('total', 'desc')
            ->first();
    }
}
