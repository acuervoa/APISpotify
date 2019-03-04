<?php

namespace App\Http\Controllers\Ranking;

use App\Album;
use App\Artist;
use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Artist\ArtistController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Genre\GenreController;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RankingController extends Controller {

    public function showStatistics() {


        $tracksInfo = self::getTracksRanking(Ranking::SHORT);
        Log:info($tracksInfo);
        $albumsInfo = AlbumController::getAlbumsRanking(Ranking::SHORT);
        Log::info($albumsInfo);
        $artistsInfo = ArtistController::getArtistRanking(Ranking::SHORT);
        Log::info($artistsInfo);
        $genresInfo = GenreController::getGenresRanking(Ranking::SHORT);
        Log::info($genresInfo);
     //   $lastTracks = TrackController::getLastTracks(Ranking::SHORT);
$lastTracks = [];

exit();
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
        return Track::distinct()->count();
    }

    public function getDistinctNumberOfAlbums() {
        return Album::distinct()->count();
    }

    public function getDistinctNumberOfArtists() {
         return Artist::distinct()->get(['artist_id'])->count();
    }

    public function getNumberOfUsers() {
        return SpotifyProfile::distinct()->count();
    }


    public function rankingTracks()
    {
        $tracksInfo = Track::getTracksInfo(self::getTracksRanking(Ranking::LARGE));
        return view('tracks.ranking', compact('tracksInfo'));
    }

    public static function getTracksRanking($limit)
    {


        $tracks = DB::table('profile_tracks')
                    ->select('track_id', DB::raw('count(*) as total'))
                    ->groupBy('track_id')
                    ->orderBy('total', 'desc')
                    ->take($limit)
                    ->get();

        return $tracks->pluck('track_id')->all();
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
