<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditPostTest extends TestCase
{
    use RefreshDatabase;

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'title' => 'Existing Post Title',
            'body' => 'Existing post content'
        ], $overrides);
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Updated Post Title',
            'body' => 'Updated post content'
        ], $overrides);
    }

    /** @test */
    function users_can_view_the_posts_index()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $publishedPostA = factory(Post::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedPostB = factory(Post::class)->create(['published_at' => '2015-01-01 00:00:00']);
        $unpublishedPost = factory(Post::class)->create(['published_at' => null]);
        $publishedPostC = factory(Post::class)->create(['published_at' => '2017-12-31 00:00:00']);

        $response = $this->actingAs($user)->get('/dashboard/posts');

        $response->assertStatus(200);
        $response->data('posts')->assertEquals([
            $publishedPostA,
            $publishedPostB,
            $unpublishedPost,
            $publishedPostC
        ]);
    }

    /** @test */
    function guests_cannot_view_the_post_index()
    {
        $publishedPostA = factory(Post::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedPostB = factory(Post::class)->create(['published_at' => '2015-01-01 00:00:00']);
        $unpublishedPost = factory(Post::class)->create(['published_at' => null]);
        $publishedPostC = factory(Post::class)->create(['published_at' => '2017-12-31 00:00:00']);

        $response = $this->get('/dashboard/posts');

        $response->assertRedirect('/login');
    }

    /** @test */
    function users_can_view_the_edit_form_for_posts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->get("/dashboard/post/{$post->id}/edit");

        $response->assertStatus(200);
        $this->assertTrue($response->data('post')->is($post));
    }

    /** @test */
    function users_see_a_404_page_when_attempting_to_view_the_edit_form_for_a_post_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/dashboard/post/1337/edit");

        $response->assertStatus(404);
    }

    /** @test */
    function guests_are_asked_to_log_in_when_attempting_to_view_the_edit_form_for_posts()
    {
        $post = factory(Post::class)->states('unpublished')->create();

        $response = $this->get("/dashboard/post/{$post->id}/edit");

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function users_can_edit_posts()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/post/{$post->id}", $this->validParams());

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertRedirect('/dashboard/posts');
            $this->assertEquals($post->title, 'Updated Post Title');
            $this->assertEquals($post->body, 'Updated post content');
        });
    }

    /** @test */
    function users_see_a_404_page_when_attempting_to_edit_a_post_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->put("/dashboard/post/1337", $this->validParams());

        $response->assertStatus(404);
    }

    /** @test */
    function guests_cannot_edit_posts()
    {
        $post = factory(Post::class)->states('unpublished')->create($this->oldAttributes());

        $response = $this->put("/dashboard/post/{$post->id}", $this->validParams());

        $response->assertRedirect('/login');
        $this->assertArraySubset($this->oldAttributes(), $post->fresh()->getAttributes());
    }

    /** @test */
    function title_is_required()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create($this->oldAttributes());

        $response = $this->from("/dashboard/post/{$post->id}/edit")->actingAs($user)->put("/dashboard/post/{$post->id}", $this->validParams(['title' => '']));

        $response->assertRedirect("/dashboard/post/{$post->id}/edit");
        $response->assertSessionHasErrors('title');
        $this->assertArraySubset($this->oldAttributes(), $post->fresh()->getAttributes());
    }

    /** @test */
    function body_is_optional()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $post = factory(Post::class)->states('unpublished')->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/post/{$post->id}", $this->validParams(['body' => '']));

        tap($post->fresh(), function ($post) use ($response) {
            $response->assertRedirect('/dashboard/posts');
            $this->assertEquals($post->title, 'Updated Post Title');
            $this->assertNull($post->body);
        });
    }
}