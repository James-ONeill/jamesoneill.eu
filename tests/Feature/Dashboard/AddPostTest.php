<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPostTest extends TestCase
{
    use RefreshDatabase;

    protected function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'How to do the thing',
            'body' => '- Step One: This is how to do the thing...',
        ], $overrides);
    }

    /** @test */
    function user_can_view_the_create_post_form()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard/post/add');

        $response->assertStatus(200);
    }

    /** @test */
    function adding_a_valid_post()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/posts', $this->validParams());

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect('/dashboard/posts');

            $this->assertEquals('How to do the thing', $post->title);
            $this->assertEquals('- Step One: This is how to do the thing...', $post->body);
            $this->assertEquals('how-to-do-the-thing', $post->slug);
        });
    }

    /** @test */
    function guests_cannot_add_new_posts()
    {
        $response = $this->post('/dashboard/posts', $this->validParams());

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertEquals(0, Post::count());
    }

    /** @test */
    function title_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/post/add')->post('/dashboard/posts', $this->validParams(['title' => '']));

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/post/add');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Post::count());
    }

    /** @test */
    function body_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/posts', $this->validParams(['body' => '']));

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect('/dashboard/posts');

            $this->assertEquals('How to do the thing', $post->title);
            $this->assertNull($post->body);
            $this->assertEquals('how-to-do-the-thing', $post->slug);
        });
    }
}