<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Possession::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->text,
        'description' => $faker->paragraph,
        'permissions' => $faker->shuffle([1, 2, 3]),
        // 'user_id' => function () {
        //     return factory(App\User::class)->create()->id;
        // }
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->unique()->word
    ];
});