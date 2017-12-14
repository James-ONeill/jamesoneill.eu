<?php

namespace Tests\Feature\Dashboard;

use App\Talk;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddTalkTest extends TestCase
{
    use RefreshDatabase;

    protected function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'How to Do The Thing',
            'event' => 'FooBarCon',
            'slide_deck_url' => 'http://example.com',
            'video_url' => 'https://youtube.com',
        ], $overrides);
    }

    /** @test */
    function user_can_view_the_create_post_form()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/dashboard/talk/add');

        $response->assertStatus(200);
    }

    /** @test */
    function guest_cannot_view_the_create_post_form()
    {
        $response = $this->get('/dashboard/talk/add');

        $response->assertRedirect('/login');
    }

    /** @test */
    function a_user_can_create_a_new_talk()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/dashboard/talks', $this->validParams());

        tap(Talk::first(), function ($talk) use ($response) {
            $response->assertRedirect('/dashboard/talks');
            $this->assertEquals('How to Do The Thing', $talk->title);
            $this->assertEquals('FooBarCon', $talk->event);
            $this->assertEquals('http://example.com', $talk->slide_deck_url);
            $this->assertEquals('https://youtube.com', $talk->video_url);
        });
    }

    /** @test */
    function a_guest_cannot_create_a_new_talk()
    {
        $response = $this->post('/dashboard/talks', $this->validParams());

        $response->assertRedirect('/login');
        $this->assertEquals(0, Talk::count());
    }

    /** @test */
    function title_is_required()
    {
        $user = factory(User::class)->create();

        $response = $this->from('/dashboard/post/add')->actingAs($user)->post('/dashboard/talks', $this->validParams(['title' => '']));

        $response->assertRedirect('/dashboard/post/add');
        $this->assertEquals(0, Talk::count());
    }

    /** @test */
    function event_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->from('/dashboard/post/add')->actingAs($user)->post('/dashboard/talks', $this->validParams(['event' => '']));

        tap(Talk::first(), function ($talk) use ($response) {
            $response->assertRedirect('/dashboard/talks');
            $this->assertEquals('How to Do The Thing', $talk->title);
            $this->assertNull($talk->event);
            $this->assertEquals('http://example.com', $talk->slide_deck_url);
            $this->assertEquals('https://youtube.com', $talk->video_url);
        });
    }

    /** @test */
    function slide_deck_url_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->from('/dashboard/post/add')->actingAs($user)->post('/dashboard/talks', $this->validParams(['slide_deck_url' => '']));

        tap(Talk::first(), function ($talk) use ($response) {
            $response->assertRedirect('/dashboard/talks');
            $this->assertEquals('How to Do The Thing', $talk->title);
            $this->assertEquals('FooBarCon', $talk->event);
            $this->assertNull($talk->slide_deck_url);
            $this->assertEquals('https://youtube.com', $talk->video_url);
        });
    }

    /** @test */
    function video_url_is_optional()
    {
        $user = factory(User::class)->create();

        $response = $this->from('/dashboard/post/add')->actingAs($user)->post('/dashboard/talks', $this->validParams(['video_url' => '']));

        tap(Talk::first(), function ($talk) use ($response) {
            $response->assertRedirect('/dashboard/talks');
            $this->assertEquals('How to Do The Thing', $talk->title);
            $this->assertEquals('FooBarCon', $talk->event);
            $this->assertEquals('http://example.com', $talk->slide_deck_url);
            $this->assertNull($talk->video_url);
        });
    }
}
