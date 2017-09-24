<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use App\MailingList\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendPostPublishedMessage;

class PublishedPostsController extends Controller
{
    public function store()
    {
        $post = Post::findOrFail(request('post_id'));

        if ($post->is_published) {
            abort(422);
        }

        $post->publish();

        SendPostPublishedMessage::dispatch($post);

        return redirect()->route('dashboard.posts.index');
    }

    public function destroy(Post $post)
    {
        if (! $post->is_published) {
            abort(422);
        }

        $post->unpublish();

        return redirect()->route('dashboard.posts.index');
    }
}
