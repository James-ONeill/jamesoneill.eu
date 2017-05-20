<?php

use Tests\Feature\Dashboard;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function logging_in_with_valid_credentials()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'james@example.com',
            'password' => bcrypt('super-secret-password')
        ]);

        $response = $this->post('/login', [
            'email' => 'james@example.com',
            'password' => 'super-secret-password'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }
}