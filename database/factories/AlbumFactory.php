<?php

use Faker\Generator as Faker;

$factory->define(App\Album::class, function (Faker $faker) {
    return [
        'album_id' => $faker->uuid,
        'name' => $faker->name,
        'image_url' => $faker->imageUrl(),
        'link_to' => $faker->url,
    ];
});
