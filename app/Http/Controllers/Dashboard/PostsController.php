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
            'title' => ['required', 'unique:posts,title'],
            'body' => 'nullable'
        ]);

        $post = Post::create($params);

        return $post;
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $params = request()->validate([
            'title' => ['required', 'unique:posts,title'],
        ]);

        $post->update(request(['title', 'body']));

        return $post;
    }
}
