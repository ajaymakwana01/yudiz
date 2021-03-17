<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

//facke data set up for product
$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->name(),
        'product_quantity' => $faker->numberBetween(50, 500),
        'product_price' => $faker->numberBetween(1, 800000),
        'product_status' => $faker->boolean()
    ];
});
