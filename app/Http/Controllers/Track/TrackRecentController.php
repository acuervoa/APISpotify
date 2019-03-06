<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Ranking;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackRecentController extends Controller {


    public function recentTracks()
    {
        return $this->getRecentTracksFromSpotify();
    }

    public function showRecentTracks()
    {
        $list = $this->getRecentTracksAllUsers( Ranking::SHORT );
        return view( 'tracks.users', compact('list'));
    }


    public function getRecentTracksAllUsers($limit): array
    {
        $spotifyProfiles = SpotifyProfile::orderBy( 'nick', 'asc' )->get();

        $trackComplete = [];
        foreach ($spotifyProfiles as $a_spotifyProfile) {

            $tracksByProfile = DB::table( 'profile_tracks' )
                ->select( 'track_id', 'played_at' )
                ->where( 'profile_id', $a_spotifyProfile->profile_id )
                ->orderBy( 'played_at', 'desc' )
                ->limit( $limit )
                ->get();

            foreach ($tracksByProfile as $index => $tracks) {
                $trackComplete[$a_spotifyProfile->nick][$index] = [
                    'data'   => TrackController::fillTracksInfo( Arr::wrap( $tracks->track_id ) ),
                    'played' => $tracks->played_at
                ];

            }

        };

        return $trackComplete;
    }


    public function getRecentTracksFromSpotify(): array
    {
        $spotifyWebAPI   = new SpotifyWebAPI();
        $spotifyProfiles = SpotifyProfile::orderBy( 'nick', 'asc' )->get();

        $list = [];

        foreach ($spotifyProfiles as $a_spotifyProfile) {
            try {
                debug($a_spotifyProfile->nick . ' -> ' . $a_spotifyProfile->accessToken);
                $spotifyWebAPI->setAccessToken( $a_spotifyProfile->accessToken );
                $recentTracks = $spotifyWebAPI->getMyRecentTracks();

                Log::info( 'Recent tracks for ' . $a_spotifyProfile->nick );

                $list[$a_spotifyProfile->nick] = $recentTracks;


                /*@TODO    $this->saveRecentTrackInfo($recentTracks, $a_spotifyProfile); */

            } catch (\Exception $e) {
                Log::error( 'I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage() );
            }
        }

        //$this->saveRecentTracksInfo($list);
        return $list;
    }

    public static function getLastTracks($limit)
    {
        $lastTracks = DB::table( 'profile_tracks' )
            ->orderby( 'played_at', 'desc' )
            ->limit( $limit )
            ->get();

        $response = [];

        foreach ($lastTracks as $index => $profileTrack) {
            $response[$index]['profile'] = SpotifyProfile::find( $profileTrack->profile_id );
            $response[$index]['track']   = Track::find( $profileTrack->track_id )->load( 'album', 'artists' );
            $response[$index]['played']  = $profileTrack->played_at;
        }

        return $response;
    }

    private function saveRecentTracksInfo(array $recentTracksInfo)
    {
        foreach ($recentTracksInfo as $profile_id => $elements) {

            foreach ($elements as $a_element) {

                $played_at = ( new Carbon( $a_element['played_at'] ) )->toDateTimeString();

                $track = TrackController::saveTrackInfo( $a_element->track );
                $track->profiles()->withPivot( $played_at )->attach( $profile_id );
            }
        }
    }
}
