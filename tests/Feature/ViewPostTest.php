<?php

namespace Tests\Feature;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewPostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_read_a_single_post()
    {
        $post = factory(Post::class)->create([
            'title' => 'Hello, World',
            'body' => '# Content'
        ]);

        $response = $this->get($post->url());
        $response->assertStatus(200);
    }
}
