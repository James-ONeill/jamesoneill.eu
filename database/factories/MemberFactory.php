<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\MailingList\Member::class, function (Faker\Generator $faker) {
    return ['email' => $faker->unique()->email];
});