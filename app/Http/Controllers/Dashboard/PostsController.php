<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    /**
     * Show the posts index dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.posts.index', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Show the create post dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.posts.create');
    }

    /**
     * Create a new post.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'nullable',
            'thumbnail' => ['nullable', 'file', 'mimes:jpeg,png'],
        ]);

        $post = Post::create(array_merge(request(['title', 'body']), [
            'thumbnail_url' => request()->hasFile('thumbnail') ? request('thumbnail')->storePublicly('thumbnails') : null
        ]));

        return redirect()->route('dashboard.posts.edit', $post);
    }

     /**
      * Show the edit post dashboard.
      *
      * @return \Illuminate\View\View
      */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    /**
     * Update an existing post.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Post $post)
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'nullable',
            'thumbnail' => ['nullable', 'file', 'mimes:jpeg,png'],
        ]);

        $post->update(array_merge(request(['title', 'body']), [
            'thumbnail_url' => request()->hasFile('thumbnail') ? request('thumbnail')->storePublicly('public/thumbnails') : $post->thumbnail_url
        ]));

        return redirect()->route('dashboard.posts.edit', $post);
    }
}
