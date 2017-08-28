<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->words(3, true),
        'body' => '# Hello, World',
        'thumbnail_url' => null,
        'published_at' => Carbon\Carbon::now()
    ];
});