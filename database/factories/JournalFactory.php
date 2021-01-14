<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    $authorId1 = rand(1,7);
    return [
        'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'describe' => $faker->paragraph($nbSentences = 7, $variableNbSentences = true),
        'image' => '/image.jpg',
        'authors' => $faker->randomDigitNot($authorId1) . ',' . $authorId1,
        'relise_date' => $faker->date($format = 'Y-m-d', $max = 'now')
    ];
});
