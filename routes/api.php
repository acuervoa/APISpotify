<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/auth', 'Spotify\SpotifySessionController@authSpotifySession');
Route::get('/callback', 'Spotify\SpotifySessionController@callback');
Route::get('/refresh', 'Spotify\SpotifySessionController@refreshToken');
