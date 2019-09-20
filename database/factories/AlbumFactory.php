<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Album::class, function (Faker $faker) {
    return [
        'album_id' => $faker->word,
        'name' => $faker->name,
        'image_url_640x640' => $faker->word,
        'image_url_300x300' => $faker->word,
        'image_url_64x64' => $faker->word,
        'link_to' => $faker->word,
    ];
});
