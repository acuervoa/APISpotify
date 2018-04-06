<?php

namespace App\Http\Controllers\Genre;

use App\Ranking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopGenres($limit) {

        $genres = DB::table('artist_genres')
            ->select('artist_genres.genre_id', DB::raw('count(*) as total'))
            ->groupBy('artist_genres.genre_id')
            ->orderBy('total', 'desc')
            ->take($limit)
            ->get();


        return $genres;
    }


    public static function getGenresRanking($limit)
    {
        return self::getTopGenres($limit);

    }




}
