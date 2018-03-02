<?php

namespace App\Http\Controllers\API;

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
        $topTrackList = TrackController::getTracksRanking($max);
        $topTrackList = Track::getTracksCompleteData($topTrackList)->tracks;

        $topAlbums = AlbumController::getAlbumsRanking($max);
        $topAlbums = AlbumController::getAlbumsCompleteData($topAlbums)->albums;

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
        $image = $element->images[0]->url;
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
        $image = $element->album->images[0]->url;
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
