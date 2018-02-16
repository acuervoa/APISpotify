<?php

namespace App\Http\Controllers\Track;

use App\Artist;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Spotify\SpotifySessionController;
use App\SpotifyProfile;
use App\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\SpotifyWebAPI;

class TrackController extends Controller
{

    public function recentTracks()
    {
        $list = $this->getRecentTracks();

        return redirect('/rankingTracks');
    }

    public function showRecentTracks()
    {

        $list = $this->getRecentTracks();

        return view('tracks.users', compact('list'));

    }

    public function getRecentTracks()
    {
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyProfiles = SpotifyProfile::all();
        $list = [];
        foreach ($spotifyProfiles as $a_spotifyProfile) {
            try {
                $spotifyWebAPI->setAccessToken($a_spotifyProfile->accessToken);
                $recentTracks = $spotifyWebAPI->getMyRecentTracks();
                $list[$a_spotifyProfile->nick] = $recentTracks;
                $this->saveRecentTracks($recentTracks, $a_spotifyProfile);
            } catch (\Exception $e) {
                Log::info('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
            }
        }

        return $list;
    }


    public function saveRecentTracks($array, $spotifyProfile)
    {

        foreach ($array->items as $element) {
            $played_at = (new Carbon($element->played_at))->toDateTimeString();
            $response = [
                'played_at' => $played_at,
                'track_id' => $element->track->id,
                'album_id' => $element->track->album->id,
                'name' => $element->track->name,
                'popularity' => $element->track->popularity,
                'tracked_by' => $spotifyProfile->nick,
            ];
            $track = Track::firstOrCreate([
                'played_at' => $played_at,
                'track_id' => $element->track->id,
            ], $response);
            $this->saveArtist($element->track->artists, $track);

        }

    }

    public function rankingTracks()
    {

        return Track::getTracksInfo(self::getTracksRanking());

    }

    public static function getTracksRanking()
    {
        $tracks = DB::table('tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->groupBy('track_id')
            ->orderBy('total', 'desc')
            ->take(50)
            ->get();


        return $tracks->pluck('track_id')->all();

    }

    public static function scheduleRecoveryTracks()
    {

    }

    public function saveAlbums()
    {

        $tracksGroups = Track::all()->pluck('track_id')->chunk(50)->toArray();

        foreach ($tracksGroups as &$a_track_group) {
            $tracksInfo = Track::getTracksCompleteData($a_track_group);
            foreach ($tracksInfo as $a_track) {
                foreach ($a_track as $track) {

                    Track::where(['track_id' => $track->id])
                        ->update(['album_id' => $track->album->id]);

                    $this->saveArtist($track);

                }
            }
        }

        //$this->saveAllGenres();

    }

    private function saveArtist($track)
    {

        $artists = $track->artists;

        foreach ($artists as $a_artist) {
            $response = [
                'artist_id' => $a_artist->id,
                'name' => $a_artist->name,
                'played_at' => $track->profiles[0]->played_at[0]->played_at,
                'tracked_by' => $track->profiles[0]->tracked_by,
                'album_id' => $track->album->id,
                'track_id' => $track->id,
            ];
            $artist = Artist::firstOrCreate(
                [
                    'artist_id' => $a_artist->id,
                    'played_at' => $track->profiles[0]->played_at[0]->played_at,
                ], $response);

            // $this->saveGenre($artist, $track);
        }
    }

    public function saveAllGenres()
    {

        $artistsGroups = Artist::all()->pluck('artist_id')->chunk(50)->toArray();

        foreach ($artistsGroups as $a_artistGroup) {

            $artistsInfo = Artist::getArtistsCompleteData($a_artistGroup);
            foreach ($artistsInfo as $a_artist_group) {
                foreach ($a_artist_group as $a_artist) {
                    $genres = $a_artist->genres;
                    foreach ($genres as $genre) {
                        Genre::firstOrCreate(
                            ['name' => strtolower($genre),
                                'artist_id' => $a_artist->id],
                            ['name' => strtolower($genre),
                                'artist_id' => $a_artist->id]
                        );
                    }
                }
            }
        }

        
    }


    private function saveGenre($artist, $track)
    {

//        dd($track);
        $clientToken = SpotifySessionController::clientCredentials();
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        $artist_id = $artist->artist_id;
        $artistInfo = $spotifyWebAPI->getArtist($artist_id);

        $genres = $artistInfo->genres;

        foreach ($genres as $a_genre) {
            Genre::firstOrCreate(
                [
                    'name' => strtolower($a_genre),
                    'played_at' => $track->profiles[0]->played_at[0]->played_at,
                ],
                [
                    'name' => strtolower($a_genre),
                    'played_at' => $track->profiles[0]->played_at[0]->played_at,
                    'tracked_by' => $track->profiles[0]->tracked_by,
                    'album_id' => $track->album->id,
                ]
            );
        }

    }

}
