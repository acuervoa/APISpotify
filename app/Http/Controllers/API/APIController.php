<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Album\AlbumRankingController;
use App\Http\Controllers\Track\TrackRankingController;
use App\Track;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Track\TrackController;

class APIController extends Controller
{
    /**
     * Return the top albums and songs.
     *
     * @param  int $max
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTops($max = 3)
    {
        // get tops
        $topTrackList = TrackRankingController::getTracksRankingLastDay($max);
        $topAlbums = AlbumRankingController::getAlbumsRankingLastDay($max);

        // get detailed info
        $topTrackList = TrackController::getTracksCompleteData($topTrackList);
        $topAlbums = AlbumController::getAlbumsCompleteData($topAlbums);

        return response()->json([
            'albums' => array_map([$this, 'minimizeAlbumData'], $topAlbums),
            'tracks' => array_map([$this, 'minimizeTrackData'], $topTrackList),
        ]);
    }

    /**
     * Simplify album data.
     *
     * @param  object $element
     * @return array
     */
    protected function minimizeAlbumData($element)
    {

        $image = $element->image_url_640x640;
        $name = $element->name;
        $artists = [];
        foreach ($element->artists as $a) {
            $artists[] = $a->name;
        }

        return [
            'image' => $image,
            'name' => $name,
            'artist' => implode(', ', $artists),
        ];
    }

    /**
     * Simplify song data.
     *
     * @param  object $element
     * @return array
     */
    protected function minimizeTrackData($element)
    {

        $image = $element->album->image_url_640x640;
        $name = $element->name;
        $artists = [];
        foreach ($element->artists as $a) {
            $artists[] = $a->name;
        }

        return [
            'image' => $image,
            'name' => $name,
            'artist' => implode(', ', $artists)
        ];
    }
}
