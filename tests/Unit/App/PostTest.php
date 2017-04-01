<?php

namespace Tests\Unit\App;

use App\Post;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function getting_the_post_url()
    {
        $post = factory(Post::class)->create([
            'published_at' => Carbon::parse('2001-01-01'),
            'title' => 'Hello, World'
        ]);

        $this->assertEquals('/2001/01/01/hello-world', $post->fresh()->url());
    }
}
