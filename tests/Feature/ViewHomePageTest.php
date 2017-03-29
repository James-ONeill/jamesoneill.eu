<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ViewHomePageTest extends TestCase
{
    /** @test */
    public function can_view_the_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
