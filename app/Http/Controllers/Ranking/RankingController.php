<?php

namespace App\Http\Controllers\Ranking;

use App\Artist;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Genre\GenreController;
use App\Http\Controllers\Track\TrackController;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use DebugBar\DebugBar;

class RankingController extends Controller {


    public function showStatistics() {

        $tracksInfo = [];
        $albumsInfo = [];
        $artistsInfo = [];


        $track_id = TrackController::getTracksRanking(Ranking::SHORT);
        if(sizeof($track_id) > 0) $tracksInfo = Track::getTracksCompleteData($track_id);

        $albums_id = AlbumController::getAlbumsRanking(Ranking::SHORT);
        if(sizeof($albums_id)>0) $albumsInfo = AlbumController::getAlbumsCompleteData($albums_id);


        $artists_id = ArtistController::getArtistRanking(Ranking::SHORT);
        if(sizeof($artists_id) > 0) $artistsInfo = ArtistController::getArtistsCompleteData($artists_id);


        $genresInfo = GenreController::rankingGenres();


        $lastTracks = TrackController::getLastTracks(Ranking::SHORT);


        return view('statistics.layout', [
            'tracks' => (!empty($tracksInfo)) ? $tracksInfo->tracks : [],
            'albums' => (!empty($albumsInfo)) ? $albumsInfo->albums : [],
            'artists' => (!empty($artistsInfo)) ? $artistsInfo->artists : [],
            'genres' => $genresInfo,
            'numberUsers' => $this->getNumberOfUsers(),
            'numberOfTracks' => $this->getDistinctNumberOfTracks(),
            'numberOfAlbums' => $this->getDistinctNumberOfAlbums(),
            'numberOfArtists' => $this->getDistinctNumberOfArtists(),
            'lastTracks' => $lastTracks
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

    public function getNumberOfUsers() {
        return SpotifyProfile::distinct()->get()->count();
    }

    /**
     * Show top tracks and albums endpoint for posterdigital display.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPosterDigitalTops()
    {
        return view('posterdigital.tops');
    }
}
