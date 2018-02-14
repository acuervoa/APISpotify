<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackController extends Controller {

    public function recentTracks() {
        $list = $this->getRecentTracks();

        return redirect('/rankingTracks');
    }

    public function showRecentTracks() {

        $list = $this->getRecentTracks();

        return view('tracks.users', compact('list'));

    }

    public function getRecentTracks() {
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyProfiles = SpotifyProfile::all();
        $list = [];
        try {
            foreach ($spotifyProfiles as $a_spotifyProfile) {
                $spotifyWebAPI->setAccessToken($a_spotifyProfile->accessToken);
                $recentTracks = $spotifyWebAPI->getMyRecentTracks();
                $list[$a_spotifyProfile->nick] = $recentTracks;
                $this->saveRecentTracks($recentTracks, $a_spotifyProfile);
            }
        } catch (\Exception $e) {
            Log::info('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
        }

        return $list;
    }


    public function saveRecentTracks($array, $spotifyProfile) {

        // dd($spotifyProfile);
        foreach ($array->items as $element) {
            $played_at = (new Carbon($element->played_at))->toDateTimeString();
            $response = [
                'played_at' => $played_at,
                'track_id' => $element->track->id,
                'name' => $element->track->name,
                'popularity' => $element->track->popularity,
                'tracked_by' => $spotifyProfile->nick,
            ];
            Track::firstOrCreate([
                'played_at' => $played_at,
                'track_id' => $element->track->id,
            ], $response);
        }

    }

    public function rankingTracks() {

        return Track::getTracksInfo(self::getTracksRanking());

    }

    public static function getTracksRanking(){
        $tracks = DB::table('tracks')
                    ->select('track_id', DB::raw('count(*) as total'))
                    ->groupBy('track_id')
                    ->orderBy('total', 'desc')
                    ->take(20)
                    ->get();
        $tracks_id = [];
        foreach ($tracks as $a_track) {
            $tracks_id[] = $a_track->track_id;
        }

        return $tracks_id;
    }

    public static function scheduleRecoveryTracks() {

    }


}
