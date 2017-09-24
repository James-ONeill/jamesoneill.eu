<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnpublishPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_unpublish_posts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('published')->create();

        $response = $this->actingAs($user)->delete("/dashboard/published-posts/{$post->id}");

        $response->assertRedirect('/dashboard/posts');
        $post = $post->fresh();
        $this->assertFalse($post->is_published);
    }

    /** @test */
    function posts_can_only_be_unpublished_once()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->delete("/dashboard/published-posts/{$post->id}");

        $response->assertStatus(422);
    }

    /** @test */
    function a_guest_cannot_unpublish_posts()
    {
        $post = factory(Post::class)->states('published')->create();

        $response = $this->delete("/dashboard/published-posts/{$post->id}");

        $response->assertRedirect('/login');
        $this->assertTrue($post->fresh()->is_published);
    }

    /** @test */
    function posts_that_do_not_exist_cannot_be_unpublished()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-posts/999');

        $response->assertStatus(404);
    }
}
