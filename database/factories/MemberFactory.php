<?php

use App\MailingList\Member;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Member::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email
    ];
});