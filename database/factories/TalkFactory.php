<?php

use App\Talk;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Talk::class, function (Faker $faker) {
    return [
        'title' => 'Talk Title',
        'event' => 'An Event',
        'slide_deck_url' => 'http://example.com',
        'video_url' => 'https://youtube.com',
        'published_at' => null
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(Talk::class, 'published', function () {
    return [
        'published_at' => (new Carbon)->subWeeks(1)
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->state(Talk::class, 'unpublished', function () {
    return [
        'published_at' => null
    ];
});
