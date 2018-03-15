<?php

use Faker\Generator as Faker;

$factory->define(App\Genre::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
