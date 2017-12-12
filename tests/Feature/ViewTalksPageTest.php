<?php

namespace Tests\Feature;

use App\Talk;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTalksPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_view_the_talks_page()
    {
        $this->withoutExceptionHandling();

        $publishedTalkA = factory(Talk::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedTalkB = factory(Talk::class)->create(['published_at' => '2017-01-31 00:00:00']);
        $publishedTalkC = factory(Talk::class)->create(['published_at' => '2017-01-15 00:00:00']);
        $unpublishedTalk = factory(Talk::class)->create();

        $response = $this->get('/talks');

        $response->assertStatus(200);
        $response->data('talks')->assertEquals([
            $publishedTalkB,
            $publishedTalkC,
            $publishedTalkA,
        ]);
        $response->data('talks')->assertNotContains($unpublishedTalk);
    }
}
