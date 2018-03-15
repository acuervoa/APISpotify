<?php

use Faker\Generator as Faker;

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
        'artist_id' => $faker->uuid,
        'name' => $faker->name,
        'image_url' => $faker->imageUrl(),
        'link_to' => $faker->url
    ];
});
