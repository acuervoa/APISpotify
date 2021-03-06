<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Ranking\RankingController@showStatistics');
Route::get('/rankingTracks', 'Track\TrackController@rankingTracks');
Route::get('/recentTracks', 'Track\TrackController@showRecentTracks');

Route::get('/refreshTokens', 'Spotify\SpotifySessionController@refreshTokens');

/**
 * Poster Digital routes.
 */
Route::group(['prefix' => 'posterdigital'], function () {

    Route::get('/tops', 'Ranking\RankingController@showPosterDigitalTops');

});
