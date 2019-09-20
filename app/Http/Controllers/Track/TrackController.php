<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Controller;
use App\Track;
use Illuminate\Support\Facades\DB;

class TrackController extends Controller
{

    public static function getTracksCompleteData($tracks_ranking_ids)
    {
        return TrackRankingController::sortTrackByReproductions(TrackController::fillTracksInfo($tracks_ranking_ids));
    }


    /**
     * @param $element
     * @param $response_track
     *
     * @return mixed
     */
    public static function saveTrackInfo($element)
    {
        return Track::firstOrCreate([
            'track_id' => $element->track->id,
            'album_id' => $element->track->album->id
        ], [
            'track_id' => $element->track->id,
            'name' => $element->track->name,
            'album_id' => $element->track->album->id,
            'preview_url' => $element->track->preview_url,
            'link_to' => $element->track->href,
            'duration_ms' => $element->track->duration_ms
        ]);
    }


    public static function getTrackReproductions(Track $a_track)
    {
        return DB::table('profile_tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_id', $a_track->track_id)
            ->groupBy('track_id')
            ->first();
    }


    /**
     * @param array $track_ids
     * @return array
     */
    public static function fillTracksInfo(array $track_ids): array
    {

        $tracks = [];

        foreach ($track_ids as $track_id) {
            $track = Track::find($track_id);

            if (empty($track->link_to)) {
                $trackInfo = Track::getSpotifyData($track_id);

                $track = Track::updateOrCreate(
                    ['track_id' => $track_id],
                    [
                        'preview_url' => $trackInfo->preview_url,
                        'link_to' => $trackInfo->href,
                        'duration_ms' => $trackInfo->duration_ms,
                    ]
                );


                AlbumController::fillAlbumsInfo([$trackInfo->album->id]);

                $artists_ids=[];
                foreach ($trackInfo->artists as $artist) {
                    $artists_ids[] = $artist->id;
                }

                $artists = ArtistController::fillArtistsInfo($artists_ids);

                foreach ($artists as $artist) {
                    $track->artists()->attach($artist);
                }
            }

            $tracks[] = $track->load('album', 'artists');
        }


        return $tracks;
    }
}
