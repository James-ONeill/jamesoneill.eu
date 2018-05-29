<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedPostsController extends Controller
{
    public function store()
    {
        $post = Post::findOrFail(request('post_id'));

        if ($post->is_published) {
            abort(422);
        }

        $post->publish();

        return $post;
    }

    public function destroy()
    {
        $post = Post::findOrFail(request('post_id'));

        if (! $post->is_published) {
            abort(422);
        }

        $post->unpublish();

        return $post;
    }
}
