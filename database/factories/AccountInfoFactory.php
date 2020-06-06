<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AccountInfo;
use Faker\Generator as Faker;

$factory->define(AccountInfo::class, function (Faker $faker) {
    return [
        'account' => $faker->unique()->bothify('??????####'),
        'name' => $faker->name,
        'sex' => $faker->numberBetween($min = 0, $max = 1),
        'birthday' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'email' => $faker->unique()->safeEmail,
        'memo' => $faker->realText($maxNbChars = 30, $indexSize = 2)
    ];
});
