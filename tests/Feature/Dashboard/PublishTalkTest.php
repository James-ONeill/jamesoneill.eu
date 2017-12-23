<?php

namespace Tests\Feature\Dashboard;

use App\Talk;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishTalkTest extends TestCase
{
    /** @test */
    function publishing_an_unpublished_talk()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->post('/dashboard/published-talks', ['talk_id' => $talk->id]);

        $response->assertRedirect('/dashboard/talks');
        $this->assertTrue($talk->fresh()->is_published);
    }

    /** @test */
    function a_talk_can_only_be_published_once()
    {
        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create(['published_at' => '2017-01-01 00:00:00']);

        $response = $this->actingAs($user)->post('/dashboard/published-talks', ['talk_id' => $talk->id]);

        $response->assertStatus(422);
        $this->assertEquals($talk->fresh()->published_at, '2017-01-01 00:00:00');
    }

    /** @test */
    function a_user_cannot_publish_a_talk_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-talks', [
            'talk_id' => 9999
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    function a_guest_cannot_publish_talks()
    {
        $talk = factory(Talk::class)->states('unpublished')->create();

        $response = $this->post('/dashboard/published-posts', ['talk_id' => $talk->id]);

        $response->assertRedirect('/login');
        $this->assertFalse($talk->fresh()->is_published);
    }
}
