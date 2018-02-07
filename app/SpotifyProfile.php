<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
