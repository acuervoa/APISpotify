<?php

namespace App\Http\Controllers\Ranking;

use App\Artist;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Genre\GenreController;
use App\Http\Controllers\Track\TrackController;
use App\Ranking;
use App\Track;

class RankingController extends Controller {


    public function showStatistics() {

        $track_id = TrackController::getTracksRanking(Ranking::SHORT);
        $tracksInfo = Track::getTracksCompleteData($track_id);

        $albums_id = AlbumController::getAlbumsRanking(Ranking::MEDIUM);
        $albumsInfo = AlbumController::getAlbumsCompleteData($albums_id);

        $artists_id = ArtistController::getArtistRanking(Ranking::SHORT);
        $artistsInfo = ArtistController::getArtistsCompleteData($artists_id);

        $genresInfo = GenreController::rankingGenres();

        return view('statistics.layout', [
            'tracks' => $tracksInfo->tracks,
            'albums' => $albumsInfo->albums,
            'artists' => $artistsInfo->artists,
            'genres' => $genresInfo,
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
