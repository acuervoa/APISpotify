<?php

use Faker\Generator as Faker;

$factory->define(App\Album::class, function (Faker $faker) {
    return [
        'album_id' => $faker->uuid,
        'name' => $faker->name,
        'image_url_600x600' => $faker->imageUrl(600,600),
        'image_url_300x300' => $faker->imageUrl(300,300),
        'image_url_64x64' => $faker->imageUrl(64,64),
        'link_to' => $faker->url,
    ];
});
