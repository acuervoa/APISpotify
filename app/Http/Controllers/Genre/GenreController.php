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
    private static function getGroupedGenres($limit) {
        $albums = DB::table('genres')
                    ->select('name', DB::raw('count(*) as total'))
                    ->groupBy('name')
                    ->orderBy('total', 'desc')
                    ->take($limit)
                    ->get();

        return $albums;
    }


    public static function rankingGenres()
    {
        return self::getGroupedGenres(Ranking::SHORT);

    }




}
