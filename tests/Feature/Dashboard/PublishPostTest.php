<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_publish_an_unpublished_post()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', ['post_id' => $post->id]);

        $response->assertRedirect('/dashboard/posts');
        $this->assertTrue($post->fresh()->is_published);
    }

    /** @test */
    function a_post_can_only_be_published_once()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create(['published_at' => '2017-01-01 00:00:00']);

        $response = $this->actingAs($user)->post('/dashboard/published-posts', ['post_id' => $post->id]);

        $response->assertStatus(422);
        $this->assertEquals($post->fresh()->published_at, '2017-01-01 00:00:00');
    }

    /** @test */
    function a_user_cannot_publish_a_post_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => 9999
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    function a_guest_cannot_publish_posts()
    {
        $post = factory(Post::class)->states('unpublished')->create();

        $response = $this->post('/dashboard/published-posts', ['post_id' => $post->id]);

        $response->assertRedirect('/login');
        $this->assertFalse($post->fresh()->is_published);
    }
}
