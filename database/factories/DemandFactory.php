<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Demand;
use Faker\Generator as Faker;

$factory->define(Demand::class, function (Faker $faker) {
    return [
        'category_id' => rand(1, 5),
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'project_delay' => rand(1, 4),
        'description' => $faker->text(200)
    ];
});
