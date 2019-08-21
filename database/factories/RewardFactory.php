<?php

use Faker\Generator as Faker;

$factory->define(App\Reward::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'redeemable' => 1, 
        'redeemed' => 0, 
        'type' => 'gift',
        'rank' => 0
    ];
});
