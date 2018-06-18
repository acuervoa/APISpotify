<?php

namespace App\Http\Controllers\RefactorDB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RefactorDBController extends Controller
{

    public function __construct()
    {

    }

    private function refactorTracks()
    {
        $tracks = DB::raw('INSERT INTO `tracks_new` (`track_id`, `album_id`, `name`)
                                  SELECT DISTINCT `track_id`, `album_id`, `name`
                                    FROM `tracks`
                                    GROUP BY `track_id`');

    }

    private function refactorAlbums()
    {
        $albums = DB::raw('INSERT INTO `albums_new` (`album_id`)
                                  SELECT DISTINCT `album_id`
                                  FROM `tracks`');
    }

    private function refactorProfileTracks()
    {
        $profileTracks = DB::raw('INSERT INTO `profile_tracks_new` 
                                      (`profile_id`, `track_id`, `played_at`, `created_at`)
                                    SELECT `spotify_profiles`.`id`,
                                            `tracks`.`track_id`,
                                            `tracks`.`played_at`, 
                                            `tracks`.`created_at`
                                    FROM `tracks`
                                    INNER JOIN `spotify_profiles` 
                                      ON `spotify_profiles`.`nick` = `tracks`.`tracked_by`');
    }

    private function refactorArtists(){

        $artists = DB::raw('INSERT INTO `artists_new` (`artist_id`, `name`) 
	                          SELECT `artists`.`artist_id`, `artists`.`name` 
	                            FROM `artists`
	                            GROUP BY `artists`.`artist_id`');
    }

    private function refactorArtistsTracks(){
        $artistTracks = DB::raw('INSERT INTO artist_tracks_new(artist_id, track_id)
                                  SELECT artist_id, track_id FROM artists
                                    GROUP BY track_id 
                                    ORDER BY artist_id, track_id');
    }

    private function refactorAlbumArtists() {
        $albumArtists = DB::raw('INSERT INTO album_artists_new (artist_id, album_id)
                                    SELECT DISTINCT artist_id, album_id 
                                      FROM artists
                                      ORDER BY artist_id');
    }

    private function refactorGenres(){
        $genres = DB::raw('INSERT INTO genres_new(name)
                            SELECT DISTINCT(name) 
                            FROM genres');
    }

    private function refactorAlbumGenres() {
        $genres = DB::raw('INSERT INTO albums_genres_new(album_id, genre_id)
                            SELECT DISTINCT(album_id), genres_new.genre_id
                             FROM genres
                             JOIN genres_new ON genres_new.name = genres.name
                             ORDER BY album_id');


    }
}

