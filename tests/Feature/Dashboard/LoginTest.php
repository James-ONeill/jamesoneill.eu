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

    /** @test */
    function logging_in_with_invalid_credentials()
    {
        $this->disableExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'james@example.com',
            'password' => bcrypt('super-secret-password')
        ]);

        $response = $this->post('/login', [
            'email' => 'james@example.com',
            'password' => 'not-the-right-password'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertFalse(Auth::check());
    }

    /** @test */
    function logging_in_with_an_account_that_does_not_exist()
    {
        $this->disableExceptionHandling();

        $response = $this->post('/login', [
            'email' => 'nobody@example.com',
            'password' => 'not-the-right-password'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertFalse(Auth::check());
    }
}