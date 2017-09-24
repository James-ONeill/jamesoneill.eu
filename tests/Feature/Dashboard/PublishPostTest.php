<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use App\Events\PostPublished;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_publish_posts()
    {
        $this->withoutExceptionHandling();
        $this->expectsEvents(PostPublished::class);

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/dashboard/posts');
        $post = $post->fresh();
        $this->assertTrue($post->is_published);
    }

    /** @test */
    function a_post_can_only_be_published_once()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('published')->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    function a_guest_cannot_publish_posts()
    {
        $post = factory(Post::class)->create();

        $response = $this->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/login');
        $this->assertFalse($post->fresh()->is_published);
    }

    /** @test */
    function posts_that_do_not_exist_cannot_be_published()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => 999,
        ]);

        $response->assertStatus(404);
    }
}
