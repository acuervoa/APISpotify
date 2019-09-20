<?php

namespace App\Http\Controllers\RefactorDB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RefactorDBController extends Controller
{

    public function __invoke()
    {
        print_r($this->refactorTracks());

        print_r($this->refactorAlbums());
        print_r($this->refactorProfileTracks());
        print_r($this->refactorArtists());
        print_r($this->refactorArtistsTracks());
        print_r($this->refactorAlbumArtists());
        print_r($this->refactorGenres());
        print_r($this->refactorAlbumGenres());
    }

    private function refactorTracks()
    {
        $tracks = DB::raw('INSERT INTO `tracks` (`track_id`, `album_id`, `name`)
                                  SELECT DISTINCT `track_id`, `album_id`, `name`
                                    FROM `tracks_old`
                                    GROUP BY `track_id`');

        return $tracks;
    }

    private function refactorAlbums()
    {
        $albums = DB::raw('INSERT INTO `albums` (`album_id`)
                                  SELECT DISTINCT `album_id`
                                  FROM `tracks_old`');

        return $albums;
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

        return $profileTracks;
    }

    private function refactorArtists()
    {

        $artists = DB::raw('INSERT INTO `artists` (`artist_id`, `name`) 
	                          SELECT `artists_old`.`artist_id`, `artists_old`.`name` 
	                            FROM `artists_old`
	                            GROUP BY `artists_old`.`artist_id`');

        return $artists;
    }

    private function refactorArtistsTracks()
    {
        $artistTracks = DB::raw('INSERT INTO artist_tracks(artist_id, track_id)
                                  SELECT artist_id, track_id FROM artists_old
                                    GROUP BY track_id 
                                    ORDER BY artist_id, track_id');

        return $artistTracks;
    }

    private function refactorAlbumArtists()
    {
        $albumArtists = DB::raw('INSERT INTO album_artists (artist_id, album_id)
                                    SELECT DISTINCT artist_id, album_id 
                                      FROM artists_old
                                      ORDER BY artist_id');

        return $albumArtists;
    }

    private function refactorGenres()
    {
        $genres = DB::raw('INSERT INTO genres(name)
                            SELECT DISTINCT(name) 
                            FROM genres_old');

        return $genres;
    }

    private function refactorAlbumGenres()
    {
        $albumGenres = DB::raw('INSERT INTO album_genres(album_id, genre_id)
                            SELECT DISTINCT(album_id), genres.genre_id
                             FROM genres_old
                             JOIN genres ON genres.name = genres_old.name
                             ORDER BY album_id');

        return $albumGenres;
    }
}
