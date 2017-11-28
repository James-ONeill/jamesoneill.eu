<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewBlogPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function user_can_view_the_blog_page()
    {
        $this->withoutExceptionHandling();

        $publishedPostA = factory(Post::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedPostB = factory(Post::class)->create(['published_at' => '2017-01-31 00:00:00']);
        $publishedPostC = factory(Post::class)->create(['published_at' => '2017-01-15 00:00:00']);

        $unpublishedPost = factory(Post::class)->create();

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->data('posts')->assertEquals([
            $publishedPostB,
            $publishedPostC,
            $publishedPostA,
        ]);
        $response->data('posts')->assertNotContains($unpublishedPost);
    }
}
