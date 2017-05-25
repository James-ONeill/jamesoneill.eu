<?php

namespace Tests\Feature\Dashboard;

use App\Post;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditPostTest extends TestCase
{
    use DatabaseMigrations;

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
}