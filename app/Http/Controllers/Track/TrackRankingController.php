<?php

namespace App\Http\Controllers\Track;

use App\Http\Controllers\Controller;
use App\Ranking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrackRankingController extends Controller
{



    /**
     * @param $tracks
     * @return mixed
     */
    public static function sortTrackByReproductions(array $tracks)
    {
        foreach ($tracks as $a_track) {
            $reproductions = TrackController::getTrackReproductions($a_track);
            $a_track->reproductions = $reproductions->total;

            usort($tracks, function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }
        return $tracks;
    }


    public static function getTracksRanking($limit)
    {

        $tracks = DB::table('profile_tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->groupBy('track_id')
            ->orderBy('total', 'desc')
            ->take($limit);

        return $tracks->pluck('track_id')->all();
    }

    public function rankingTracks()
    {
        return view(
            'tracks.ranking',
            ['tracksInfo' => TrackController::getTracksCompleteData(self::getTracksRanking(Ranking::LARGE))]
        );
    }

    /**
     * Get top tracks from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getTracksRankingLastDay($limit)
    {
        $tracks = DB::table('profile_tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('played_at', '>=', Carbon::now()->subDays(2))
            ->groupBy('track_id')
            ->orderBy('total', 'desc')
            ->orderBy('track_id', 'desc')
            ->take($limit)
            ->get();

        return $tracks->pluck('track_id')->all();
    }
}
