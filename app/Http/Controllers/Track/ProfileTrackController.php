<?php

namespace App\Http\Controllers\Track;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProfileTrackController extends Controller
{
    /**
     * @param $reproductions
     * @return mixed
     */
    public static function getProfileReproductions($reproductions)
    {
        $profiles = DB::table('profile_tracks')
            ->select('profile_id', DB::raw('count(*) as times'))
            ->where('track_id', $reproductions->track_id)
            ->groupBy('profile_id')
            ->get();

        foreach ($profiles as $a_profile) {
            $a_profile->played_at = self::getWhenPlayedAtTracked($reproductions->track_id, $a_profile->profile_id);
            $a_profile->realReproductions = $a_profile->times;
            $a_profile->ponderatedReproductions = round(sqrt($a_profile->times));
        }

        return $profiles;
    }

    public static function getWhenPlayedAtTracked($track_id, $tracked_by)
    {

        return DB::table('profile_tracks')
            ->select('played_at')
            ->where('track_id', $track_id)
            ->where('profile_id', $tracked_by)
            ->orderby('played_at', 'desc')
            ->get();
    }
}
