<?php

use Faker\Generator as Faker;

$factory->define(\App\Track::class, function (Faker $faker) {
    return [
        'track_id' => $faker->uuid,
        'name' => $faker->name,
        'album_id' => factory(\App\Album::class)->create()->album_id,
        'preview_url' => $faker->url,
        'link_to' => $faker->url,
        'duration_ms' => $faker->randomNumber(4),
    ];
});
