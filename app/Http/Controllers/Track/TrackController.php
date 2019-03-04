<?php

namespace App\Http\Controllers\Track;

use App\Album;
use App\Artist;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Spotify\SpotifySessionController;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;

use DebugBar\DebugBar;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;


class TrackController extends Controller
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
                $this->saveRecentTracks($recentTracks, $a_spotifyProfile);

            } catch (\Exception $e) {
                Log::error('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
            }
        }

        $this->saveRecentTracksInfo($list);
        return $list;
    }

    private function saveRecentTracksInfo(array $recentTracksInfo)
    {
        foreach ($recentTracksInfo as $profile_id => $elements) {

            foreach($elements as $a_element) {

                $played_at = (new Carbon($a_element['played_at']))->toDateTimeString();

                $track = $this->saveTrackInfo($a_element->track);
                $track->profiles()->withPivot($played_at)->attach($profile_id);
            }
        }
    }

    /**
     * @param $element
     * @param $response_track
     *
     * @return mixed
     */
    private function saveTrackInfo($element)
    {
        return Track::firstOrCreate([
            'track_id' => $element->track->id,
            'album_id' => $element->track->album->id
        ], [
            'track_id' => $element->track->id,
            'name' => $element->track->name,
            'album_id' => $element->track->album->id,
            'preview_url' => $element->track->preview_url,
            'link_to' => $element->track->href,
            'duration_ms' => $element->track->duration_ms
        ]);

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
            ->where('played_at', '>=', Carbon::now()->subDay())
            ->groupBy('track_id')
            ->orderBy('total', 'desc')
            ->orderBy('track_id', 'desc')
            ->take($limit)
            ->get();

        return $tracks->pluck('track_id')->all();
    }






    public static function getTrackReproductions(Track $a_track)
    {
        return DB::table('profile_tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('track_id', $a_track->track_id)
            ->groupBy('track_id')
            ->first();
    }

    /**
     * @param $tracks
     * @return mixed
     */
    private static function sortTrackByReproductions(array $tracks)
    {
        foreach ($tracks as $a_track) {

            $reproductions = self::getTrackReproductions($a_track);
            $a_track->reproductions = $reproductions->total;

            usort($tracks, function ($a, $b) {
                return ($a->reproductions <= $b->reproductions) ? 1 : -1;
            });
        }
        return $tracks;
    }

    /**
     * @param array $track_ids
     * @return array
     */
    private static function fillTracksInfo(array $track_ids): array
    {

        $tracks = [];
        foreach ($track_ids as $track_id) {
            $track = Track::find($track_id);

            if (empty($track->link_to)) {

                $trackInfo = Track::getSpotifyData($track_id);

                $track = Track::updateOrCreate(['track_id' => $track_id],
                    [
                        'preview_url' => $trackInfo->preview_url,
                        'link_to' => $trackInfo->href,
                        'duration_ms' => $trackInfo->duration_ms,
                    ]);


            }

            $tracks[] = $track;
        }
        return $tracks;
    }

}
