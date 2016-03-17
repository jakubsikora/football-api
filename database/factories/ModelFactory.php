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

$factory->define(App\League::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->word(),
        'name' => $faker->word()
    ];
});

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word()
    ];
});

$factory->define(App\Result::class, function (Faker\Generator $faker) {
    return [
        'league_id' => rand(1,5),
        'date' => $faker->date(),
        'home_team_id' => rand(1,20),
        'away_team_id' => $faker->word(),
        'ft_home_goals' => rand(0,6),
        'ft_away_goals' => rand(0,6),
        'ft_result' => $faker->randomElement(array ('h','d','a')),
        'ht_home_goals' => $faker->numberBetween(0, 6),
        'ht_away_goals' => $faker->numberBetween(0, 6),
        'ht_result' => $faker->randomElement(array ('h','d','a')),
        'referee' => $faker->lastName()
    ];
});