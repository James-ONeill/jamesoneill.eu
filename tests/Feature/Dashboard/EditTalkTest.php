<?php

namespace Tests\Feature\Dashboard;

use App\Talk;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditTalkTest extends TestCase
{
    use RefreshDatabase;

    private function oldAttributes($overrides = [])
    {
        return array_merge([
            'title' => 'My Talk',
            'event' => 'Somewhere',
            'slide_deck_url' => 'http://example.com',
            'video_url' => 'https://youtube.com',
        ], $overrides);
    }

    protected function validParams($attributes = [])
    {
        return array_merge([
            'title' => 'My Updated Talk',
            'event' => 'Somewhere Else',
            'slide_deck_url' => 'http://example.com/talk',
            'video_url' => 'https://youtube.com/talk',
        ], $attributes);
    }

    /** @test */
    function users_can_view_the_talks_index()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $publishedTalkA = factory(Talk::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedTalkB = factory(Talk::class)->create(['published_at' => '2015-01-01 00:00:00']);
        $unpublishedTalk = factory(Talk::class)->create(['published_at' => null]);
        $publishedTalkC = factory(Talk::class)->create(['published_at' => '2017-12-31 00:00:00']);

        $response = $this->actingAs($user)->get('/dashboard/talks');

        $response->assertStatus(200);
        $response->data('talks')->assertEquals([
            $publishedTalkA,
            $publishedTalkB,
            $unpublishedTalk,
            $publishedTalkC
        ]);
    }

    /** @test */
    function guests_cannot_view_the_talks_index()
    {
        $publishedTalkA = factory(Talk::class)->create(['published_at' => '2017-01-01 00:00:00']);
        $publishedTalkB = factory(Talk::class)->create(['published_at' => '2015-01-01 00:00:00']);
        $unpublishedTalk = factory(Talk::class)->create(['published_at' => null]);
        $publishedTalkC = factory(Talk::class)->create(['published_at' => '2017-12-31 00:00:00']);

        $response = $this->get('/dashboard/talks');

        $response->assertRedirect('/login');
    }

    /** @test */
    function users_can_view_the_edit_form_for_talks()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->states('unpublished')->create();

        $response = $this->actingAs($user)->get("/dashboard/talk/{$talk->id}/edit");

        $response->assertStatus(200);
        $this->assertTrue($response->data('talk')->is($talk));
    }

    /** @test */
    function users_see_a_404_page_when_attempting_to_view_the_edit_form_for_a_talk_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get("/dashboard/talk/1337/edit");

        $response->assertStatus(404);
    }

    /** @test */
    function guests_are_asked_to_log_in_when_attempting_to_view_the_edit_form_for_talks()
    {
        $talk = factory(Talk::class)->states('unpublished')->create();

        $response = $this->get("/dashboard/talk/{$talk->id}/edit");

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    function successfully_editing_a_talk()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/talk/{$talk->id}", $this->validParams());

        $response->assertRedirect('/dashboard/talks');
        $this->assertArraySubset($this->validParams(), $talk->fresh()->getAttributes());
    }

    /** @test */
    function users_see_a_404_page_when_attempting_to_edit_a_post_that_does_not_exist()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->put("/dashboard/talk/1337", $this->validParams());

        $response->assertStatus(404);
    }

    /** @test */
    function guests_are_redirected_to_the_login_page_when_attemting_to_edit_talks()
    {
        $talk = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->put("/dashboard/talk/{$talk->id}", $this->validParams());

        $response->assertRedirect('/login');
        $this->assertArraySubset($this->oldAttributes(), $talk->fresh()->getAttributes());
    }

    /** @test */
    function title_is_required()
    {
        $user = factory(User::class)->create();
        $post = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->from("/dashboard/talk/{$post->id}/edit")->actingAs($user)->put("/dashboard/talk/{$post->id}", $this->validParams(['title' => '']));

        $response->assertRedirect("/dashboard/talk/{$post->id}/edit");
        $response->assertSessionHasErrors('title');
        $this->assertArraySubset($this->oldAttributes(), $post->fresh()->getAttributes());
    }

    /** @test */
    function event_is_optional()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/talk/{$talk->id}", $this->validParams(['event' => '']));

        $response->assertRedirect('/dashboard/talks');
        $this->assertArraySubset($this->validParams(['event' => null]), $talk->fresh()->getAttributes());
    }

    /** @test */
    function slide_deck_url_is_optional()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/talk/{$talk->id}", $this->validParams(['slide_deck_url' => '']));

        $response->assertRedirect('/dashboard/talks');
        $this->assertArraySubset($this->validParams(['slide_deck_url' => null]), $talk->fresh()->getAttributes());
    }

    /** @test */
    function video_url_is_optional()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $talk = factory(Talk::class)->create($this->oldAttributes());

        $response = $this->actingAs($user)->put("/dashboard/talk/{$talk->id}", $this->validParams(['video_url' => '']));

        $response->assertRedirect('/dashboard/talks');
        $this->assertArraySubset($this->validParams(['video_url' => null]), $talk->fresh()->getAttributes());
    }
}
