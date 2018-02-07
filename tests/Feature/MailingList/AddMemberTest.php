<?php

namespace Tests\Feature\MailingList;

use Tests\TestCase;
use App\MailingList\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddMemberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function successfully_joining_the_mailing_list()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/mailing-list/members', [
            'email' => 'reader@example.com'
        ]);

        tap(Member::first(), function ($member) use ($response) {
            $response->assertStatus(201);
            $this->assertEquals('reader@example.com', $member->email);
        });
    }

    /** @test */
    function email_is_required()
    {
        $response = $this->postJson('/mailing-list/members', [
            'email' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message', 'errors' => ['email']
        ]);
    }

    /** @test */
    function email_must_be_valid()
    {
        $response = $this->postJson('/mailing-list/members', [
            'email' => 'not a valid email address'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message', 'errors' => ['email']
        ]);
    }

    /** @test */
    function email_must_be_unique()
    {
        factory(Member::class)->create(['email' => 'duplicate@example.com']);

        $response = $this->postJson('/mailing-list/members', [
            'email' => 'duplicate@example.com'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message', 'errors' => ['email']
        ]);
    }
}
