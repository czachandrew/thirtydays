<?php

use Faker\Generator as Faker;

$factory->define(App\Challenge::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'image' => $faker->image,
        'creator_id' => 1
    ];
});
