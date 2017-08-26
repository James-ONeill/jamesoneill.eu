<?php

namespace Tests\Unit\App;

use App\Post;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function getting_the_post_url()
    {
        $post = factory(Post::class)->create([
            'published_at' => Carbon::parse('2001-01-01'),
            'title' => 'Hello, World'
        ]);

        $this->assertEquals('/2001/01/01/hello-world', $post->fresh()->url());
    }

    /** @test */
    function getting_the_body_html()
    {
        $post = $post = factory(Post::class)->make([
            'body' => '[Example Link](http://example.com)'
        ]);

        $this->assertEquals('<p><a href="http://example.com">Example Link</a></p>', $post->body_html);
    }

    /** @test */
    function getting_the_description()
    {
        $post = factory(Post::class)->make([
            'body' =>
                "In West Philadelphia born and raised
                On the playground was where I spent most of my days"
        ]);

        $this->assertEquals('In West Philadelphia born and raised', $post->description);
    }
}
