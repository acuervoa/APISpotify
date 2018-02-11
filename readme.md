SpotyPitoColorito
-

**Actual version**: 0.0.2 - ALPHA VERSION

Get data from Spotify API (https://developer.spotify.com/) from users who authorized the application.

You need a .env file with Laravel configuration.
You need also the config keys:

```
SPOTIFY_CLIENT_ID=<your client id token>
SPOTIFY_CLIENT_SECRET=<your client secret token
SPOTIFY_URI_CALLBACK=<your uri callback for auth>
```

Use the SpotifyWebAPI wrapper from ()https://github.com/jwilsson/spotify-web-api-php

The code is under GNU GPLv3 License ()

---

**TO-DO LIST**:

[ ] Screen with the more listen - Artist / Album / Song / Genre
[ ] Filter ranking with no same profile listen the same song
[ ] Album / Artist Image
[x] Cron with auto get Tracks
[ ] Filter with office hours
[ ] Generate recommended list with more listen
[ ] Example sound
[ ] Improve when the accessToken is expired