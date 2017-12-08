<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function index()
    {
        return view('dashboard.posts.index', ['posts' => Post::all()]);
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store()
    {
        $params = request()->validate([
            'title' => 'required',
            'body' => 'nullable'
        ]);

        $post = Post::create($params);

        return redirect('/dashboard/posts');
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $params = request()->validate([
            'title' => 'required',
        ]);

        $post->update(request(['title', 'body']));

        return redirect('/dashboard/posts');
    }
}
