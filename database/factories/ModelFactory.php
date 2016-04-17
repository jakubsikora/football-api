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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => Hash::make('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Season::class, function (Faker\Generator $faker) {
    $start_year = $faker->year();
    $end_year = $start_year + 1;

    return [
        'name' => 'Season ' . $faker->randomLetter(),
        'start_year' => $start_year,
        'end_year' => $end_year,
    ];
});

$factory->define(App\League::class, function (Faker\Generator $faker) {
    return [
        'name' => 'League ' . $faker->randomLetter(),
        'code' => strtoupper($faker->randomLetter()) . $faker->randomDigit(),
    ];
});

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Team ' . $faker->randomLetter()
    ];
});
