<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackRecentController extends Controller
{


    public function recentTracks()
    {
        return $this->showRecentTracks();
    }

    public function showRecentTracks()
    {
        $list = $this->getRecentTracks();
        return view('tracks.users', compact('list'));
    }

    public function getRecentTracks(): array
    {
        $spotifyWebAPI = new SpotifyWebAPI();

        $spotifyProfiles = SpotifyProfile::orderBy('nick', 'asc')->get();

        $list = [];

        foreach ($spotifyProfiles as $a_spotifyProfile) {
            try {
                $spotifyWebAPI->setAccessToken($a_spotifyProfile->accessToken);

                $recentTracks = $spotifyWebAPI->getMyRecentTracks();


                Log::info('Recent tracks for ' . $a_spotifyProfile->nick);

                $list[$a_spotifyProfile->nick] = $recentTracks;
            /*@TODO    $this->saveRecentTrackInfo($recentTracks, $a_spotifyProfile); */

            } catch (\Exception $e) {
                Log::error('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
            }
        }

        $this->saveRecentTracksInfo($list);
        return $list;
    }

    public static function getLastTracks($limit)
    {
        $lastTracks = DB::table('profile_tracks')
            ->orderby('played_at', 'desc')
            ->limit($limit)
            ->get();

        $response = [];

        foreach ($lastTracks as $index => $profileTrack) {
            $response[$index]['profile'] = SpotifyProfile::find($profileTrack->profile_id);
            $response[$index]['track'] = Track::find($profileTrack->track_id)->load('album', 'artists');
            $response[$index]['played'] = $profileTrack->played_at;
        }

        return $response;
    }

    private function saveRecentTracksInfo(array $recentTracksInfo)
    {
        foreach ($recentTracksInfo as $profile_id => $elements) {

            foreach($elements as $a_element) {

                $played_at = (new Carbon($a_element['played_at']))->toDateTimeString();

                $track = TrackController::saveTrackInfo($a_element->track);
                $track->profiles()->withPivot($played_at)->attach($profile_id);
            }
        }
    }
}
