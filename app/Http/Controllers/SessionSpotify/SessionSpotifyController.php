<?php

namespace App\Http\Controllers;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SessionSpotifyController extends Controller
{
    public $sessionSpotify;
    public $spotifyAccessToken;
    public $spotifyRefreshToken;

    public $spotifyWebAPI;

    public function __construct() {
        $this->sessionSpotify = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_URI_CALLBACK')
        );
    }

    public function authSpotifySession() {
        $options = [
            'scope' => [
                'user-read-private',
                'user-top-read',
                'user-read-recently-played',
                'user-read-currently-playing',
                'user-read-email'
            ]
        ];

        return redirect($this->sessionSpotify->getAuthorizeUrl($options));
    }

    public function callback() {

        $this->sessionSpotify->requestAccessToken($_GET['code']);
        $this->spotifyAccessToken = $this->sessionSpotify->getAccessToken();
        $this->spotifyRefreshToken = $this->sessionSpotify->getRefreshToken();

        $this->loadSpotifyAPI($this->spotifyAccessToken);
    }

    public function loadSpotifyAPI($accessToken) {

        $this->spotifyWebAPI = new SpotifyWebAPI();
        $this->spotifyWebAPI->setAccessToken($accessToken);

        dd($this->spotifyWebAPI->getMyTop('tracks'));
    }


}
