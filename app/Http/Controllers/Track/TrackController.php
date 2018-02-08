<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\SpotifyProfileController;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrackController extends Controller
{
    public function recentTracks(){

        $spotifyProfiles = SpotifyProfile::all();

        foreach($spotifyProfiles as $a_spotifyProfiles) {
            $spotifyWebAPI = $a_spotifyProfiles->getAccessProfile();
            $array = $spotifyWebAPI->getMyRecentTracks();

            $this->saveRecentTracks($array);
        }
    }

    public function saveRecentTracks($array) {

        foreach ($array->items as $element){
            $played_at = (new Carbon($element->played_at))->toDateTimeString();

            $response = [
                'played_at' => $played_at,
                'track_id' => $element->track->id,
                'name' => $element->track->name,
                'popularity' => $element->track->popularity,
            ];

            Track::firstOrCreate([ 'played_at' => $played_at, 'track_id' => $element->track->id ], $response);
        }

    }
}
