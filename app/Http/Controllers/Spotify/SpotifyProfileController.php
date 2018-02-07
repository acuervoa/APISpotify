<?php

namespace App\Http\Controllers;

use App\SpotifyProfile;
use Illuminate\Http\Request;

class SpotifyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nick' => 'required|unique',
            'email' => 'required|email|unique:spoti',
            'accessToken' => 'required',
            'refreshToken' => 'required',
        ];

        $this->validate($request, $rules);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpotifyProfile $profileSpotify
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SpotifyProfile $profileSpotify)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\SpotifyProfile      $profileSpotify
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpotifyProfile $profileSpotify)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpotifyProfile $profileSpotify
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpotifyProfile $profileSpotify)
    {
        //
    }
}
