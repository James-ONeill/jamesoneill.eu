<?php

namespace App\Jobs;

use App\MailingList\Member;
use App\Mail\PostPublished;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPostPublishedMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \App\Post  $post
     */
    public $post;

    /**
     * Create a new job instance.
     *
     * @param \App\Post  $post
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Member::get(['email'])->pluck('email')->each(function ($email) {
            Mail::to($email)->queue(new PostPublished($this->post));
        });
    }
}
