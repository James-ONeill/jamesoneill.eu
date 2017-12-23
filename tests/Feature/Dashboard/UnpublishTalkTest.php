<?php

namespace Tests\Feature\Dashboard;

use App\Talk;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnpublishTalkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_unpublish_a_published_talk()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->states('published')->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-talks', [
            'talk_id' => $talk->id
        ]);

        $response->assertRedirect('/dashboard/talks');
        $this->assertFalse($talk->fresh()->is_published);
    }

    /** @test */
    function a_talk_can_only_be_unpublished_once()
    {
        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-talks', [
            'talk_id' => $talk->id
        ]);

        $response->assertStatus(422);
        $this->assertFalse($talk->fresh()->is_published);
    }

    /** @test */
    function a_user_cannot_unpublish_a_talk_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-talks', [
            'talk_id' => 9999
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    function a_guest_cannot_unpublish_talks()
    {
        $talk = factory(Talk::class)->states('published')->create();

        $response = $this->delete('/dashboard/published-talks', [
            'talk_id' => $talk->id
        ]);

        $response->assertRedirect('/login');
        $this->assertTrue($talk->fresh()->is_published);
    }
}
