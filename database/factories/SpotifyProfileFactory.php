<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\SpotifyProfile::class, function (Faker $faker) {
    return [
        'profile_id' => $faker->word,
        'nick' => $faker->word,
        'email' => $faker->safeEmail,
        'display_name' => $faker->word,
        'country' => $faker->country,
        'href' => $faker->word,
        'image_url' => $faker->word,
        'accessToken' => $faker->word,
        'refreshToken' => $faker->word,
        'expirationToken' => $faker->word,
    ];
});
