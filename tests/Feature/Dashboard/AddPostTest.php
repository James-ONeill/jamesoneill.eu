<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddPostTest extends TestCase
{
    use RefreshDatabase;

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Writing Tests in Laravel',
            'body' => 'Testing your Laravel application is good...',
            'thumbnail' => UploadedFile::fake()->image('thumbnail.jpg'),
        ], $overrides);
    }

    private function from($url)
    {
        session()->setPreviousUrl($url);
        return $this;
    }

    /** @test */
    function users_can_view_the_add_post_form()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard/posts/new');

        $response->assertStatus(200);
    }

    /** @test */
    function guests_cannot_view_the_add_post_form()
    {
        $response = $this->get('/dashboard/posts/new');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function adding_a_valid_post()
    {
        Storage::fake('local');
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post(
            '/dashboard/posts', $this->validParams()
        );

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");

            $this->assertEquals('Writing Tests in Laravel', $post->title);
            $this->assertEquals('Testing your Laravel application is good...', $post->body);
            $this->assertNull($post->published_at);
            Storage::assertExists($post->thumbnail_url);
        });
    }

    /** @test */
    function guests_cannot_add_posts()
    {
        $response = $this->post('/dashboard/posts', $this->validParams());

        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertEquals(0, Post::count());
    }

    /** @test */
    function name_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/posts/new')->post(
            '/dashboard/posts', $this->validParams(['title' => ''])
        );

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/posts/new');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Post::count());
    }

    /** @test */
    function body_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/posts/new')->post(
            '/dashboard/posts', $this->validParams(['body' => ''])
        );

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");

            $this->assertNull($post->body);
        });
    }

    /** @test */
    function thumbnail_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/posts/new')->post(
            '/dashboard/posts', $this->validParams(['thumbnail' => null])
        );

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(302);
            $response->assertRedirect("/dashboard/posts/{$post->id}/edit");

            $this->assertNull($post->thumbnail_url);
        });
    }

    /** @test */
    function thumbnail_must_be_a_file()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/posts/new')->post(
            '/dashboard/posts', $this->validParams(['thumbnail' => 'Not a file.'])
        );

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/posts/new');
        $response->assertSessionHasErrors('thumbnail');
        $this->assertEquals(0, Post::count());
    }

    /** @test */
    function thumbnail_must_be_an_image()
    {
        Storage::fake('local');

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->from('/dashboard/posts/new')->post(
            '/dashboard/posts', $this->validParams([
                'thumbnail' => UploadedFile::fake()->create('thumbnail.pdf')
            ])
        );

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard/posts/new');
        $response->assertSessionHasErrors('thumbnail');
        $this->assertEquals(0, Post::count());
    }
}