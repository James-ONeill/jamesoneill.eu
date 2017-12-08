<?php

namespace Tests\Unit\App;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    function getting_the_first_name()
    {
        $user = factory(User::class)->make(['name' => 'John Doe']);

        $this->assertEquals('John', $user->first_name);
    }

    /** @test */
    function getting_the_last_name()
    {
        $user = factory(User::class)->make(['name' => 'John Doe']);

        $this->assertEquals('Doe', $user->last_name);
    }
}