<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Track::class, function (Faker $faker) {
    return [
        'track_id' => $faker->word,
        'name' => $faker->name,
        'album_id' => function () {
            return factory(App\Album::class)->create()->album_id;
        },
        'preview_url' => $faker->word,
        'link_to' => $faker->word,
        'duration_ms' => $faker->randomNumber(),
    ];
});
