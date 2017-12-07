<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewHomePageTest extends TestCase
{
    /** @test */
    function user_can_view_the_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
