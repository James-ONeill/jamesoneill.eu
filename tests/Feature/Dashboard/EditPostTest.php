<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditPostTest extends TestCase
{
    use DatabaseMigrations;

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Writing Great Tests in Laravel',
            'body' => 'Testing your Laravel application **really** is good...',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
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
        Storage::fake('local');
        $this->disableExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...'
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
            $this->assertNull($post->published_at);
            Storage::assertExists($post->thumbnail_url);
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
    function thumbnail_is_optional()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'thumbnail_url' => 'existing-thumbnail.jpg'
        ]);

        $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['thumbnail' => null])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        });
    }

    /** @test */
    function thumbnail_must_be_a_file()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'thumbnail_url' => 'existing-thumbnail.jpg'
        ]);

        $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams(['thumbnail' => 'Not a file.'])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $response->assertSessionHasErrors('thumbnail');
            $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        });
    }

    /** @test */
    function thumbnail_must_be_an_image()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'thumbnail_url' => 'existing-thumbnail.jpg'
        ]);

        $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        $response = $this->from("/dashboard/posts/{$post->id}/edit")->actingAs($user)->put(
            "/dashboard/posts/{$post->id}", $this->validParams([
                'thumbnail' => UploadedFile::fake()->image('thumbnail.pdf')
            ])
        );

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");
            $response->assertSessionHasErrors('thumbnail');
            $this->assertEquals('existing-thumbnail.jpg', $post->thumbnail_url);
        });
    }
}