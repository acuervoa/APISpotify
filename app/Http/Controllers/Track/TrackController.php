<?php

namespace App\Http\Controllers\Track;

use App\Album;
use App\Artist;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Spotify\SpotifySessionController;
use App\Ranking;
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
        return $this->showRecentTracks();
    }

    public function showRecentTracks()
    {
        $list = $this->getRecentTracks();
        return view('tracks.users', compact('list'));
    }

    public function getRecentTracks():array
    {
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyProfiles = SpotifyProfile::orderBy('nick', 'asc')->get();
        $list = [];

        foreach ($spotifyProfiles as $a_spotifyProfile) {
            try {
                $spotifyWebAPI->setAccessToken($a_spotifyProfile->accessToken);
                $recentTracks = $spotifyWebAPI->getMyRecentTracks();
                $list[$a_spotifyProfile->nick] = $recentTracks;
                $this->saveRecentTracksInfo($recentTracks, $a_spotifyProfile);
            } catch (\Exception $e) {
                Log::error('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
            }
        }

        return $list;
    }

    public function saveRecentTracksInfo($array, $spotifyProfile)
    {
        $items = $array->items;

        foreach ($items as $element) {
            $played_at = (new Carbon($element->played_at))->toDateTimeString();

            $track = $this->saveTrackInfo($element);
            $album = $this->saveAlbumInfo($element);
            $artist = $this->saveArtistInfo($element);

            if (!$this->isTrackProfilePlayedAlreadySaved($track, $played_at))
            {
                $track->profiles()
                      ->attach($spotifyProfile->profile_id, ['played_at' => $played_at]);
                $track->album->save($album->toArray());
                $album->artists()->attach($artist->artist_id);
                $this->saveGenres($artist);
            }
        }
    }

    public static function getLastTracks($limit)
    {
        return DB::table('profile_tracks')
            ->orderby('played_at', 'desc')
            ->join('tracks', 'profile_tracks.track_id', 'tracks.track_id')
            ->join('spotify_profiles', 'profile_tracks.profile_id', 'spotify_profiles.id')
            ->limit($limit)
            ->get();
    }


    /**
     * @param $element
     *
     * @return array
     */
    private function getTrackInfo($element): array {
        return [
            'track_id'    => $element->track->id,
            'name'        => $element->track->name,
            'album_id'    => $element->track->album->id,
            'preview_url' => $element->track->preview_url,
            'link_to'     => $element->track->href,
            'duration_ms' => $element->track->duration_ms
        ];

    }

    /**
     * @param $element
     *
     * @return array
     */
    private function getAlbumInfo($element): array {
        return [
            'album_id'  => $element->track->album->id,
            'name'      => $element->track->album->name,
            'image_url' => $element->track->album->images[0]->url,
            'link_to'   => $element->track->album->href,
        ];

    }

    /**
     * @param $element
     *
     * @return array
     */
    private function getArtistInfo($element): array {
        return [
            'artist_id' => $element->track->artists[0]->id,
            'name'      => $element->track->artists[0]->name,
            'link_to'   => $element->track->artists[0]->href,
        ];

    }

    /**
     * @param $artist
     *
     * @return mixed
     */
    private function getGenresFromArtist($artist) {
        $spotifyWebAPI = $this->getSpotifyWebAPI();
        $artist_id = $artist->artist_id;
        $artistInfo = $spotifyWebAPI->getArtist($artist_id);
        $genres = $artistInfo->genres;

        return $genres;
    }

    /**
     * @param $element
     * @param $response_track
     *
     * @return mixed
     */
    private function saveTrackInfo($element) {
        return Track::firstOrCreate([
            'track_id' => $element->track->id,
            'album_id' => $element->track->album->id
        ], $this->getTrackInfo($element));

    }

    /**
     * @param $element
     * @param $response_album
     *
     * @return mixed
     */
    private function saveAlbumInfo($element) {
        return  Album::firstOrCreate([
            'album_id' => $element->track->album->id
        ], $this->getAlbumInfo($element));

    }

    /**
     * @param $element
     * @param $response_artists
     *
     * @return mixed
     */
    private function saveArtistInfo($element) {
        return Artist::firstOrCreate([
            'artist_id' => $element->track->artists[0]->id
        ], $this->getArtistInfo($element));


    }

    /**
     * @param $artist
     */
    private function saveGenres($artist)
    {
        $genres = $this->getGenresFromArtist($artist);

        foreach ($genres as $a_genre) {
            $genre = Genre::firstOrCreate(
                [
                    'name' => strtolower($a_genre),
                ]
            );
            $artist->genres()->syncWithoutDetaching($genre);
        }
    }

    /**
     * @param $track
     * @param $played_at
     *
     * @return mixed
     */
    private function isTrackProfilePlayedAlreadySaved($track, $played_at) {
        return $track->profiles()
                     ->wherePivot('played_at', '=', $played_at)
                     ->first();
    }

    /**
     * @return \SpotifyWebAPI\SpotifyWebAPI
     */
    private function getSpotifyWebAPI(): \SpotifyWebAPI\SpotifyWebAPI {

        $clientToken = SpotifySessionController::clientCredentials();
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI;
    }






    public function saveAllAlbums() {
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
    }

    public function saveAllGenres()
    {

        $artistsGroups = Artist::all()
                               ->pluck('artist_id')
                               ->chunk(50)
                               ->toArray();
        foreach ($artistsGroups as $a_artistGroup) {
            $artistsInfo = Artist::getArtistsCompleteData($a_artistGroup);
            foreach ($artistsInfo as $a_artist_group) {
                foreach ($a_artist_group as $a_artist) {
                    $genres = $a_artist->genres;
                    foreach ($genres as $genre) {
                        Genre::firstOrCreate(
                            [
                                'name' => strtolower($genre),
                                'artist_id' => $a_artist->id,
                            ],
                            [
                                'name' => strtolower($genre),
                                'artist_id' => $a_artist->id,
                            ]
                        );
                    }
                }
            }
        }


    }

    private function saveAlbumsFromTracks()
    {
        $tracksAlbums = Track::distinct()->get(['album_id'])->pluck('album_id')->chunk(50)->toArray();

        foreach ($tracksAlbums as $a_trackAlbum) {
            $albumsInfo = Album::getAlbumsCompleteData($a_trackAlbum);
            foreach ($albumsInfo as $a_album) {
                Album::firstOrCreate(
                    ['name' => $a_album->name],
                    $a_album
                );
            }
        }

        dd($tracksAlbums);

    }

    /**
     * @return int
     */
    private function getDiffInMinutesFromLastTrackToNow(): int
    {
        $flag = Carbon::now();
        $getLastFlag = DB::table('tracks')
                         ->select()
                         ->orderby('played_at', 'desc')
                         ->first();
        $lastFlag = Carbon::parse($getLastFlag->played_at);

        return $lastFlag->diffInMinutes($flag, FALSE);
    }

    private function getLastTracksByUsers()
    {

        $profiles = SpotifyProfile::all();
        $list = [];
        foreach ($profiles as $profile) {

            $tracks = DB::table('tracks')
                        ->select()
                        ->where('tracked_by', $profile->nick)
                        ->orderby('played_at', 'desc')
                        ->limit(20)
                        ->join('')
                        ->get();
            $list[$profile->nick] = $tracks;
        }

        return $list;

    }


}
