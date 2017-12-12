<?php

use App\Post;
use Carbon\Carbon;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->words(3, true),
        'body' => '# Hello, World',
        'thumbnail_url' => null,
        'published_at' => null
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(Post::class, 'published', function () {
    return [
        'published_at' => (new Carbon)->subWeeks(1)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(Post::class, 'unpublished', function () {
    return [
        'published_at' => null
    ];
});