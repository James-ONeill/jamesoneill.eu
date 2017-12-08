<?php

namespace Tests\Feature\Dashboard;

use App\User;
use Tests\TestCase;

class ViewDashboardTest extends TestCase
{
    /** @test */
    function user_can_view_the_dashboard()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    /** @test */
    function guest_cannot_view_the_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}