<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'artist_id' => $faker->word,
        'name' => $faker->name,
        'image_url_640x640' => $faker->word,
        'image_url_320x320' => $faker->word,
        'image_url_160x160' => $faker->word,
        'link_to' => $faker->word,
    ];
});
