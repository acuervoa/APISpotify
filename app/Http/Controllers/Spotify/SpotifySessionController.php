<?php

namespace App\Http\Controllers\Spotify;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Error\ErrorController;
use App\SpotifyProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifySessionController extends Controller
{

    public $sessionSpotify;
    public $spotifyAccessToken;
    public $spotifyRefreshToken;
    public $spotifyTokenExpirationTime;

    public $spotifyWebAPI;

    public function __construct()
    {
        $this->sessionSpotify = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET'),
            env('SPOTIFY_URI_CALLBACK')
        );
    }

    public function authSpotifySession()
    {
        $options = [
            'scope' => [
                'user-read-private',
                'user-top-read',
                'user-read-recently-played',
                'user-read-currently-playing',
                'user-read-email',
            ],
        ];
        try {
            return redirect($this->sessionSpotify->getAuthorizeUrl($options));
        } catch (\Exception $e) {
            return ErrorController::errorHandler();
        }
    }

    public function callback()
    {
        $this->sessionSpotify->requestAccessToken($_GET['code']);
        $this->spotifyAccessToken = $this->sessionSpotify->getAccessToken();
        $this->spotifyRefreshToken = $this->sessionSpotify->getRefreshToken();
        $this->spotifyTokenExpirationTime = $this->sessionSpotify->getTokenExpiration();
        $this->saveSpotifyProfile();


        return redirect('/');
    }

    public function loadSpotifyAPI()
    {
        $spotifyProfile = SpotifyProfile::where('accessToken', '=', $this->spotifyAccessToken)
            ->get()
            ->first();
        if (NULL !== $spotifyProfile && ((int)$spotifyProfile->expirationToken <= Carbon::now()->timestamp)) {
            $this->refreshToken($this->spotifyRefreshToken);
        }

    }

    public function saveSpotifyProfile()
    {
        $this->spotifyWebAPI = new SpotifyWebAPI();
        $this->spotifyWebAPI->setAccessToken($this->spotifyAccessToken);
        $request = $this->spotifyWebAPI->me();
        $fields = [
            'profile_id' => Uuid::uuid1()->toString(),
            'nick' => $request->id,
            'email' => $request->email,
            'display_name' => $request->display_name,
            'country' => $request->country,
            'href' => $request->href,
            'image_url' => empty($request->images) ?: $request->images[0]->url,
            'accessToken' => $this->spotifyAccessToken,
        ];
        if (!empty($this->spotifyRefreshToken)) {
            $fields['refreshToken'] = $this->spotifyRefreshToken;
            Log::info('Refresh token for ' . $request->id);
        }
        if (!empty($this->spotifyRefreshToken)) {
            $fields['expirationToken'] = $this->spotifyTokenExpirationTime;
        }

        SpotifyProfile::updateOrCreate(['email' => $request->email], $fields);

    }

    public function refreshToken($refreshToken)
    {

        $allOk = TRUE;
        try {
            if ($this->sessionSpotify->refreshAccessToken($refreshToken)) {
                $this->spotifyAccessToken = $this->sessionSpotify->getAccessToken();
                $this->spotifyTokenExpirationTime = $this->sessionSpotify->getTokenExpiration();
                $this->saveSpotifyProfile();
            }
        } catch (\Exception $e) {
            Log::info('The token - ' . $refreshToken . ' is revoked');
            $allOk = FALSE;
        }

        return $allOk;
    }

    public static function clientCredentials()
    {
        $session = new Session(
            env('SPOTIFY_CLIENT_ID'),
            env('SPOTIFY_CLIENT_SECRET')
        );

        $session->requestCredentialsToken();

        return $session->getAccessToken();
    }


    /**
     * @return SpotifyWebAPI
     */
    public static function getClientAuthorization(): SpotifyWebAPI
    {
        $clientToken = self::clientCredentials();
        $spotifyWebAPI = new SpotifyWebAPI();
        $spotifyWebAPI->setAccessToken($clientToken);

        return $spotifyWebAPI;
    }

    public function refreshTokens()
    {
        $spotifyProfiles = SpotifyProfile::all();

        foreach ($spotifyProfiles as $a_profile) {
            try {
                if (!$this->refreshToken($a_profile->refreshToken)) {
                    //$a_profile->delete(['id' => (string)$a_profile->id ]);
                    Log::info('El profile de ' . $a_profile->name . ' debe ser eliminado');
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return redirect('/recentTracks');
    }

}
