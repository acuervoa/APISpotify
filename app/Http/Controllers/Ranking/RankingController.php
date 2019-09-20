<?php

namespace App\Http\Controllers\Ranking;

use App\Album;
use App\Artist;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Album\AlbumRankingController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Artist\ArtistRankingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Genre\GenreController;
use App\Http\Controllers\Track\TrackController;
use App\Http\Controllers\Track\TrackRankingController;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use Illuminate\Http\Response;

class RankingController extends Controller
{

    public function showStatistics()
    {


        $tracksInfo = TrackController::getTracksCompleteData(TrackRankingController::getTracksRanking(Ranking::SHORT));
        $albumsInfo = AlbumController::getAlbumsCompleteData(AlbumRankingController::getAlbumsRanking(Ranking::SHORT));
        $artistsInfo = ArtistController::getArtistsCompleteData(ArtistRankingController::getArtistRanking(Ranking::SHORT));

        $genresInfo = GenreController::getGenresRanking(Ranking::SHORT);
//        Log::info($genresInfo);
//        $lastTracks = TrackController::getLastTracks(Ranking::SHORT);
//        Log::info(var_dump($lastTracks));


        return view('statistics.layout', [
            'tracks' => !empty($tracksInfo) ? $tracksInfo : [],
            'albums' => !empty($albumsInfo) ? $albumsInfo : [],
            'artists' => !empty($artistsInfo) ? $artistsInfo : [],
            'genres' => !empty($genresInfo) ? $genresInfo : [],
            'numberUsers' => $this->getNumberOfUsers(),
            'numberOfTracks' => $this->getDistinctNumberOfTracks(),
            'numberOfAlbums' => $this->getDistinctNumberOfAlbums(),
            'numberOfArtists' => $this->getDistinctNumberOfArtists(),
//            'lastTracks' => $lastTracks
        ]);
    }

    public function getDistinctNumberOfTracks()
    {
        return Track::distinct()->count();
    }

    public function getDistinctNumberOfAlbums()
    {
        return Album::distinct()->count();
    }

    public function getDistinctNumberOfArtists()
    {
         return Artist::distinct()->count();
    }

    public function getNumberOfUsers()
    {
        return SpotifyProfile::distinct()->count();
    }

    /**
     * Show top tracks and albums endpoint for posterdigital display.
     *
     * @return Response
     */
    public function showPosterDigitalTops()
    {
        return view('posterdigital.tops');
    }
}
