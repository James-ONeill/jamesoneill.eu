<?php

namespace Tests\Feature\Dashboard;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function guest_can_see_the_login_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    function logging_in_with_valid_credentials()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'me@example.com',
            'password' => bcrypt('my-top-secret-password')
        ]);

        $response = $this->post('/login', [
            'email' => 'me@example.com',
            'password' => 'my-top-secret-password'
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }

    /** @test */
    function logging_in_with_invalid_credentials()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'me@example.com',
            'password' => bcrypt('my-top-secret-password')
        ]);

        $response = $this->post('/login', [
            'email' => 'me@example.com',
            'password' => 'an-incorrect-password'
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
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'me@example.com',
            'password' => bcrypt('my-top-secret-password')
        ]);

        $response = $this->post('/login', [
            'email' => 'somebodyelse@example.com',
            'password' => 'an-incorrect-password'
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertFalse(Auth::check());
    }

    /** @test */
    function logging_out_the_current_user()
    {
        $this->withoutExceptionHandling();

        Auth::login(factory(User::class)->create());

        $response = $this->post('/logout');

        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }
}
