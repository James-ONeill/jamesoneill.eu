<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->words(3, true),
        'body' => '# Hello, World',
        'thumbnail_url' => null,
        'published_at' => null
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Post::class, 'published', function () {
    return ['published_at' => (new Carbon\Carbon)->subWeeks(1)];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(App\Post::class, 'unpublished', function () {
    return ['published_at' => null];
});