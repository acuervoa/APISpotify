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
                $list[$a_spotifyProfile->profile_id] = $recentTracks;
            } catch (\Exception $e) {
                Log::error('I can\'t recovery data from ' . $a_spotifyProfile->nick . ' -- ' . $e->getMessage());
            }
        }

        $this->saveRecentTracksInfo($list);
        return $list;
    }

    public function saveRecentTracksInfo($recentTracksInfo)
    {

        foreach ($recentTracksInfo as $profile_id => $elements) {

            $profile = SpotifyProfile::find($profile_id)->load('tracks');

            foreach($elements as $a_element) {

                $played_at = (new Carbon($a_element['played_at']))->toDateTimeString();

                dd($a_element->track);
                $track = $this->saveTrackInfo($a_element->track);

            }
//
//            $album = $this->saveAlbumInfo($element);
//            $artist = $this->saveArtistInfo($element);
//
//            if (!$this->isTrackProfilePlayedAlreadySaved($track, $played_at))
//            {
//                $track->profiles()
//                      ->attach($spotifyProfile->profile_id, ['played_at' => $played_at]);
//                $track->album->save($album->toArray());
//                $album->artists()->syncWithoutDetaching($artist->artist_id);
//                $track->artists()->syncWithoutDetaching($artist->artist_id);
//                $this->saveGenres($artist);
//            }
        }
    }

    public static function getLastTracks($limit)
    {
        $lastTracks = DB::table('profile_tracks')
            ->orderby('played_at', 'desc')
            ->limit($limit)
            ->get();

        $response = [];

        foreach ($lastTracks as $index => $profileTrack) {
            $profile = SpotifyProfile::find($profileTrack->profile_id);
            if (NULL === $profile) Log::info($profileTrack->profile_id . ' is null?');
            $track = Track::find($profileTrack->track_id)->load('album', 'artists');
            $played = $profileTrack->played_at;

            $response[$index]['profile'] = $profile;
            $response[$index]['track'] = $track;
            $response[$index]['played'] = $played;
        }

        return $response;
    }


    /**
     * @param $element
     *
     * @return array
     */
    private function getTrackInfo($element): array
    {
        return [
            'track_id' => $element->track->id,
            'name' => $element->track->name,
            'album_id' => $element->track->album->id,
            'preview_url' => $element->track->preview_url,
            'link_to' => $element->track->href,
            'duration_ms' => $element->track->duration_ms
        ];

    }

    /**
     * @param $element
     *
     * @return array
     */
    private function getAlbumInfo($element): array
    {
        return [
            'album_id' => $element->track->album->id,
            'name' => $element->track->album->name,
            'image_url_640x640' => $element->track->album->images[0]->url,
            'image_url_300x300' => $element->track->album->images[1]->url,
            'image_url_64x64' => $element->track->album->images[2]->url,
            'link_to' => $element->track->album->href,
        ];

    }

    /**
     * @param $element
     *
     * @return array
     */
    private function getArtistInfo($element): array
    {
        return [
            'artist_id' => $element->track->artists[0]->id,
            'name' => $element->track->artists[0]->name,
            'link_to' => $element->track->artists[0]->href,
        ];

    }

    /**
     * @param $artist
     *
     * @return mixed
     */
    private function getGenresFromArtist($artist)
    {
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
    private function saveTrackInfo($element)
    {
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
    private function saveAlbumInfo($element)
    {
        return Album::firstOrCreate([
            'album_id' => $element->track->album->id
        ], $this->getAlbumInfo($element));

    }

    /**
     * @param $element
     * @param $response_artists
     *
     * @return mixed
     */
    private function saveArtistInfo($element)
    {
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
        $artist->genres()->syncWithoutDetaching($genres);

//        foreach ($genres as $a_genre) {
//            $genre = Genre::firstOrCreate(
//                [
//                    'name' => strtolower($a_genre),
//                ]
//            );
//
//        }
    }

    /**
     * @param $track
     * @param $played_at
     *
     * @return mixed
     */
    private function isTrackProfilePlayedAlreadySaved($track, $played_at)
    {
        return $track->profiles()
            ->wherePivot('played_at', '=', $played_at)
            ->first();
    }

    /**
     * Get top tracks from last 24 hours.
     *
     * @param  int $limit
     * @return array
     */
    public static function getTracksRankingLastDay($limit)
    {
        $tracks = DB::table('tracks')
            ->select('track_id', DB::raw('count(*) as total'))
            ->where('played_at', '>=', Carbon::now()->subDay())
            ->groupBy('track_id')
            ->orderBy('total', 'desc')
            ->orderBy('track_id', 'desc')
            ->take($limit)
            ->get();

        return $tracks->pluck('track_id')->all();
    }


    /**
     * @return \SpotifyWebAPI\SpotifyWebAPI
     */
    private function getSpotifyWebAPI(): \SpotifyWebAPI\SpotifyWebAPI
    {

        $clientToken = SpotifySessionController::clientCredentials();
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI;
    }


    public function saveAllAlbums()
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
