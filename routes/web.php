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

Route::get('/', 'Track\TrackController@recentTracks');
Route::get('/rankingTracks', 'Track\TrackController@rankingTracks');
Route::get('/recentTracks', 'Track\TrackController@showRecentTracks');

Route::get('/refreshTokens', 'Spotify\SpotifySessionController@refreshTokens');

Route::get('/viewRanks', 'Ranking\RankingController@showStatistics');

Route::get('/saveAlbums', 'Track\TrackController@saveAlbums');
Route::get('/saveGenres', 'Track\TrackController@saveAllGenres');
