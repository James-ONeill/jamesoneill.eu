<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditPostTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Writing Great Tests in Laravel',
            'body' => 'Testing your Laravel application **really** is good...',
            'publication_date' => '2001-01-01',
            'publication_time' => '12:34'
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
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams()
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application **really** is good...', $post->body);
            $this->assertEquals('2001-01-01 12:34', $post->published_at->format('Y-m-d H:i'));
        });
    }

    /** @test */
    function guests_cannot_edit_posts()
    {
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
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
            $response->assertSessionHasErrors('title');
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

    /** @test */
    function publication_date_is_optional()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['publication_date' => ''])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application **really** is good...', $post->body);
            $this->assertNull($post->published_at);
        });
    }

    /** @test */
    function publication_date_must_be_valid()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['publication_date' => 'not a valid date'])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $response->assertSessionHasErrors('publication_date');
            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
            $this->assertNull($post->published_at);
        });
    }

    /** @test */
    function publication_time_is_required_with_publication_date()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['publication_time' => ''])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $response->assertSessionHasErrors('publication_time');
            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
            $this->assertNull($post->published_at);
        });
    }

    /** @test */
    function publication_time_must_be_valid()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['publication_time' => 'not a valid time'])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $response->assertSessionHasErrors('publication_time');
            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
            $this->assertNull($post->published_at);
        });
    }

    /** @test */
    function publishing_a_post_immediately()
    {
        Carbon::setTestNow('2001-01-01 00:00');
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => null
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertNull($post->published_at);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['publish' => true])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application **really** is good...', $post->body);
            $this->assertEquals('2001-01-01 00:00', $post->published_at->format('Y-m-d H:i'));
        });
    }

    /** @test */
    function unpublishing_a_post()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'published_at' => '2001-01-01 00:00:00'
        ]);

        $this->assertEquals('Writing Tests in Laravel', $post->title);
        $this->assertEquals('Testing your Laravel application is good...', $post->body);
        $this->assertEquals('2001-01-01 00:00', $post->published_at->format('Y-m-d H:i'));
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['unpublish' => true])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('Writing Great Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application **really** is good...', $post->body);
            $this->assertNull($post->published_at);
        });
    }
}