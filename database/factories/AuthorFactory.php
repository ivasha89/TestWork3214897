<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstNameMale(),
        'last_name' => $faker->lastName(),
        'middle_name' => $faker->firstNameMale(),
    ];
});
