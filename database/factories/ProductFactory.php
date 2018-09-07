<?php

use Faker\Generator as Faker;
use App\Product;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name'=> $faker->name,
        'info'=> $faker->sentence($nbWords = 6, $variableNbWords = true),
        'pic'=>'pic'.$faker->numberBetween(1,25),
        'price'=>$faker->numberBetween(10,500),
        'created_at'=>$faker->dateTimeThisYear($max = 'now', $timezone = null),
    ];
});
