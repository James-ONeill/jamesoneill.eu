<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'nullable'
        ]);

        $post = Post::create(request(['title', 'body']));
        return redirect("/dashboard/posts/{$post->id}/edit");
    }
}
