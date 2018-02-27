SpotyPitoColorito
-

**Actual version**: 1.0.0 - BETA VERSION [https://github.com/acuervoa/APISpotify/releases/tag/v1.0.0-beta.1]

Framework: Laravel 5.5.34 [https://laravel.com]

Get data from Spotify API [https://developer.spotify.com/] from users who authorized the application.

You need a .env file with Laravel configuration.
You need also the config keys:

```
SPOTIFY_CLIENT_ID=<your client id token>
SPOTIFY_CLIENT_SECRET=<your client secret token
SPOTIFY_URI_CALLBACK=<your uri callback for auth>
```

Use the SpotifyWebAPI wrapper from [https://github.com/jwilsson/spotify-web-api-php]

The code is under GNU GPLv3 License.

---

**TO-DO LIST**:

[ ] Filter with office hours

[ ] Generate recommended list with more listenç

[x] Screen with the more listen - Artist / Album / Song / Genre

[x] Filter ranking with no same profile listen the same song

[x] Album / Artist Image

[x] Cron with auto get Tracks

[x] Example sound

[x] Improve when the accessToken is expired

[x] When a user revoke access, the application refresh crashed!
