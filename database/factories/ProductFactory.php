<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'inStock' => $faker->numberBetween(0, 100),
        'price' => $faker->numberBetween(0, 6000),
    ];
});
