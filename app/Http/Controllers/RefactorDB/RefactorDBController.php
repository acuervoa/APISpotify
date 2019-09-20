<?php

namespace App\Http\Controllers\RefactorDB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RefactorDBController extends Controller
{

    public function __invoke()
    {
        $this->refactorTracks();
        $this->refactorAlbums();
        $this->refactorProfileTracks();
        $this->refactorArtists();
        $this->refactorArtistsTracks();
        $this->refactorAlbumArtists();
        $this->refactorGenres();
        $this->refactorAlbumGenres();
    }

    private function refactorTracks()
    {
        $tracks = DB::raw('INSERT INTO `tracks` (`track_id`, `album_id`, `name`)
                                  SELECT DISTINCT `track_id`, `album_id`, `name`
                                    FROM `tracks_old`
                                    GROUP BY `track_id`');
    }

    private function refactorAlbums()
    {
        $albums = DB::raw('INSERT INTO `albums` (`album_id`)
                                  SELECT DISTINCT `album_id`
                                  FROM `tracks_old`');
    }

    private function refactorProfileTracks()
    {
        $profileTracks = DB::raw('INSERT INTO `profile_tracks` 
                                      (`profile_id`, `track_id`, `played_at`, `created_at`)
                                    SELECT `spotify_profiles`.`id`,
                                            `tracks_old`.`track_id`,
                                            `tracks_old`.`played_at`, 
                                            `tracks_old`.`created_at`
                                    FROM `tracks_old`
                                    INNER JOIN `spotify_profiles` 
                                      ON `spotify_profiles`.`nick` = `tracks_old`.`tracked_by`');
    }

    private function refactorArtists()
    {

        $artists = DB::raw('INSERT INTO `artists` (`artist_id`, `name`) 
	                          SELECT `artists_old`.`artist_id`, `artists_old`.`name` 
	                            FROM `artists_old`
	                            GROUP BY `artists_old`.`artist_id`');
    }

    private function refactorArtistsTracks()
    {
        $artistTracks = DB::raw('INSERT INTO artist_tracks(artist_id, track_id)
                                  SELECT artist_id, track_id FROM artists_old
                                    GROUP BY track_id 
                                    ORDER BY artist_id, track_id');
    }

    private function refactorAlbumArtists()
    {
        $albumArtists = DB::raw('INSERT INTO album_artists (artist_id, album_id)
                                    SELECT DISTINCT artist_id, album_id 
                                      FROM artists_old
                                      ORDER BY artist_id');
    }

    private function refactorGenres()
    {
        $genres = DB::raw('INSERT INTO genres(name)
                            SELECT DISTINCT(name) 
                            FROM genres_old');
    }

    private function refactorAlbumGenres()
    {
        $genres = DB::raw('INSERT INTO album_genres(album_id, genre_id)
                            SELECT DISTINCT(album_id), genres.genre_id
                             FROM genres_old
                             JOIN genres ON genres.name = genres_old.name
                             ORDER BY album_id');
    }
}
