<?php

namespace App\Http\Controllers\Ranking;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Track\TrackController;
use App\Track;

class RankingController extends Controller {

    public function showStatistics() {

        $track_id = TrackController::getTracksRanking();
        $tracksInfo = Track::getTracksCompleteData($track_id);

        return view('statistics.layout', [
            'tracks' => $tracksInfo->tracks,
            'numberOfTracks' => $this->getDistinctNumberOfTracks(),
            'numberOfAlbums' => $this->getDistinctNumberOfAlbums(),
            'numberOfArtists' => $this->getDistinctNumberOfArtists()
        ]);
    }

    public function getDistinctNumberOfTracks() {
        return Track::distinct()->get(['track_id'])->count();
    }

    public function getDistinctNumberOfAlbums() {
        return Track::distinct()->get(['album_id'])->count();
    }

    public function getDistinctNumberOfArtists() {
        return Artist::distinct()->get(['artist_id'])->count();
    }
}
