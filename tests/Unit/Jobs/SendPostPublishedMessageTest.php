<?php

namespace Tests\Unit\Jobs;

use App\Post;
use Tests\TestCase;
use App\MailingList\Member;
use App\Mail\PostPublished;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendPostPublishedMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendPostPublishedMessageTest extends TestCase
{
    /** @test */
    function it_sends_the_message_to_all_mailing_list_members()
    {
        Mail::fake();
        $post = factory(Post::class)->states('published')->create();

        $memberA = factory(Member::class)->create(['email' => 'tony.stark@example.com']);
        $memberB = factory(Member::class)->create(['email' => 'steve.rogers@example.com']);
        $memberC = factory(Member::class)->create(['email' => 'bruce.banner@example.com']);
        $memberD = factory(Member::class)->create(['email' => 'peter.quill@example.com']);

        SendPostPublishedMessage::dispatch($post);

        Mail::assertQueued(PostPublished::class, function ($mail) use ($post) {
            return $mail->hasTo('tony.stark@example.com') && $mail->post->is($post);
        });
        Mail::assertQueued(PostPublished::class, function ($mail) use ($post) {
            return $mail->hasTo('steve.rogers@example.com') && $mail->post->is($post);
        });
        Mail::assertQueued(PostPublished::class, function ($mail) use ($post) {
            return $mail->hasTo('bruce.banner@example.com') && $mail->post->is($post);
        });
        Mail::assertQueued(PostPublished::class, function ($mail) use ($post) {
            return $mail->hasTo('peter.quill@example.com') && $mail->post->is($post);
        });
    }
}