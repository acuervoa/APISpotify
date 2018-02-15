<?php

namespace App\Http\Controllers\Ranking;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Track\TrackController;
use App\Track;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function showStatistics()
    {
        $track_id = TrackController::getTracksRanking();

        $tracksInfo = Track::getTracksCompleteData($track_id);

        return view('statistics.layout', ['tracks' => $tracksInfo->tracks]);
    }
}
