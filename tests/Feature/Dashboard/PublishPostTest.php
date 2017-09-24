<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use App\Events\PostPublished;
use Illuminate\Support\Facades\Queue;
use App\Jobs\SendPostPublishedMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_publish_posts()
    {
        $this->withoutExceptionHandling();
        Queue::fake();
        $this->expectsEvents(PostPublished::class);

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/dashboard/posts');
        $post = $post->fresh();
        $this->assertTrue($post->is_published);
        Queue::assertPushed(SendPostPublishedMessage::class, function ($job) use ($post) {
            return $job->post->is($post);
        });
    }

    /** @test */
    function a_post_can_only_be_published_once()
    {
        Queue::fake();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('published')->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertStatus(422);
        Queue::assertNotPushed(SendPostPublishedMessage::class);
    }

    /** @test */
    function a_guest_cannot_publish_posts()
    {
        Queue::fake();

        $post = factory(Post::class)->create();

        $response = $this->post('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/login');
        $this->assertFalse($post->fresh()->is_published);
        Queue::assertNotPushed(SendPostPublishedMessage::class);
    }

    /** @test */
    function posts_that_do_not_exist_cannot_be_published()
    {
        Queue::fake();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/published-posts', [
            'post_id' => 999,
        ]);

        $response->assertStatus(404);
        Queue::assertNotPushed(SendPostPublishedMessage::class);
    }
}
