<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnpublishPostTest extends TestCase
{
    /** @test */
    function a_user_can_unpublish_a_published_post()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('published')->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/dashboard/posts');
        $this->assertFalse($post->fresh()->is_published);
    }

    /** @test */
    function a_post_can_only_be_unpublished_once()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertStatus(422);
        $this->assertFalse($post->fresh()->is_published);
    }

    /** @test */
    function a_user_cannot_unpublish_a_post_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->delete('/dashboard/published-posts', [
            'post_id' => 9999
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    function a_guest_cannot_unpublish_posts()
    {
        $post = factory(Post::class)->states('published')->create();

        $response = $this->delete('/dashboard/published-posts', [
            'post_id' => $post->id
        ]);

        $response->assertRedirect('/login');
        $this->assertTrue($post->fresh()->is_published);
    }
}
