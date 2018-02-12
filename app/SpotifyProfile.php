<?php

namespace App;

use App\Http\Controllers\Spotify\SpotifySessionController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyProfile extends Model
{
    use SoftDeletes;

    protected $table = 'spotify_profiles';
    protected $dates =['deleted_at'];

    protected $fillable = [
        'id',
        'nick',
        'email',
        'display_name',
        'country',
        'href',
        'image_url',
        'accessToken',
        'refreshToken',
        'expirationToken'
    ];

    protected $hidden = [
        'email',
        'accessToken',
        'refreshToken',
        'expirationToken'
    ];


    public function getAccessProfile(){
        $spotifyWebAPI = new SpotifyWebAPI();


        if((int)$this->expirationToken <= Carbon::now()->timestamp){
            $spotifySession = new SpotifySessionController();
            if($spotifySession->refreshToken($this->refreshToken)) {
                $this->accessToken = $spotifySession->spotifyAccessToken;
                $this->expirationToken = $spotifySession->spotifyTokenExpirationTime;
                $this->save();
            }
        }

        $spotifyWebAPI->setAccessToken($this->accessToken);

        return $spotifyWebAPI;
    }



}
