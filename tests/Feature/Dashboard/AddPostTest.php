<?php

namespace Tests\Feature\Dashboard;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddPostTest extends TestCase
{
    use DatabaseMigrations;

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

}