<?php

use Faker\Generator as Faker;

$factory->define(App\SpotifyProfile::class, function (Faker $faker) {
    return [
        'profile_id' => $faker->uuid,
        'nick' => $faker->userName,
        'email'=> $faker->email,
        'display_name' => $faker->name,
        'country' => $faker->countryCode,
        'href' => $faker->url,
        'image_url' => $faker->imageUrl(),
        'accessToken' => $faker->sha256,
        'refreshToken'=> $faker->sha256,
        'expirationToken' => $faker->sha256,
    ];
});
