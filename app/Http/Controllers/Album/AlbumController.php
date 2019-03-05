<?php

namespace App\Http\Controllers\Album;


use App\Album;
use App\Http\Controllers\Artist\ArtistController;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class AlbumController extends Controller
{



    /**
     * @param $albums
     * @return array
     */
    public static function fillAlbumsInfo(array $albums): array
    {

        debug('albums', $albums);

        $response = [];

        foreach ($albums as $album_id) {
            $album = Album::find($album_id);

            if (empty($album->link_to)) {
               $infoAlbum = Album::getSpotifyData($album_id);

               $images = [
                   'image_url_640x640' => array_key_exists(0, $infoAlbum->images) ?? $infoAlbum->images[0]->url,
                   'image_url_300x300' => array_key_exists(1, $infoAlbum->images) ?? $infoAlbum->images[1]->url,
                   'image_url_64x64' => array_key_exists(2, $infoAlbum->images) ?? $infoAlbum->images[2]->url
               ];
               $album = Album::updateOrCreate(['album_id' => $album_id], [
                    'name' => $infoAlbum->name,
                    $images,
                    'link_to' => $infoAlbum->href
                ]);

            }


            $response[] = $album->load('artists');
        }

        return $response;
    }




    public static function getAlbumsCompleteData(array $albums_ranking_ids)
    {
        return AlbumRankingController::sortAlbumsByReproductions(self::fillAlbumsInfo($albums_ranking_ids));

    }

    public static function getAlbumReproductions(Album $a_album)
    {

    }

}
