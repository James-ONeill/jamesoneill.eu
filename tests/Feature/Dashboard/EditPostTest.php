<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditPostTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Writing Great Tests in Laravel',
            'body' => 'Testing your Laravel application **really** is good...'
        ], $overrides);
    }

    private function from($url)
    {
        session()->setPreviousUrl($url);
        return $this;
    }

    /** @test */
    function users_can_view_the_posts_index()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard/posts');

        $response->assertStatus(200);
    }

    /** @test */
    function guests_cannot_view_the_posts_index()
    {
        $response = $this->get('/dashboard/posts');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function users_can_view_the_edit_posts_form()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->actingAs($user)->get("/dashboard/posts/{$post->id}/edit");

        $response->assertStatus(200);
        $response->assertViewHas('post', function ($viewPost) use ($post) {
            return $viewPost->is($post);
        });
    }

    /** @test */
    function guests_cannot_view_the_edit_posts_form()
    {
        $post = factory(Post::class)->create();

        $response = $this->get("/dashboard/posts/{$post->id}/edit");

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function editing_a_valid_post()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...'
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $response = $this->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams()
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application **really** is good...', $post->body);
        });
    }

    /** @test */
    function guests_cannot_edit_posts()
    {
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...'
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $response = $this->put(
            "/dashboard/posts/{$post->id}", $this->validParams()
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect('/login');
            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
        });
    }

    /** @test */
    function title_is_required()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...'
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['title' => ''])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
        });
    }

    /** @test */
    function body_is_optional()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...'
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['body' => ''])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertNull($post->body);
        });
    }
}