<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'provider_id'=>1,
        'line_id'=>1,
        'barcode' => $faker->ean13,   
        'description' => $faker->name,
        //'price_1' => $faker->randomNumber(4),

        
    ];
});
