<?php

namespace App\Http\Controllers\Genre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    private static function getTopGenres(int $limit)
    {

        $topGenres = DB::table('album_genres')
            ->select('album_genres.genre_id', DB::raw('count(*) as total'))
            ->groupBy('album_genres.genre_id')
            ->orderBy('total', 'desc')
            ->take($limit);

        return DB::table(DB::raw('(' . $topGenres->toSql() . ') as topGenres'))
            ->mergeBindings($topGenres)
            ->join('genres', 'genres.genre_id', '=', 'topGenres.genre_id')
            ->select('genres.genre_id', 'genres.name', 'topGenres.total')
            ->get();
    }


    public static function getGenresRanking(int $limit)
    {
         return self::getTopGenres($limit);
    }
}
