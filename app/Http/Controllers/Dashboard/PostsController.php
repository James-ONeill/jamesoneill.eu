<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    public function index()
    {
        return view('dashboard.posts.index', [
            'posts' => Post::all()
        ]);
    }

    public function create()
    {
        return view('dashboard.posts.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'nullable',
            'publication_date' => ['nullable', 'date'],
            'publication_time' => ['nullable', 'required_with:publication_date', 'date_format:H:i'],
            'publish' => 'nullable'
        ]);

        $publishedAt = null;

        if (request()->has('publish')) {
            $publishedAt = Carbon::now();
        } else if (request()->has('publication_date')) {
            $publishedAt = Carbon::parse(vsprintf('%s %s', request([
                'publication_date', 'publication_time'
            ])));
        }

        $post = Post::create(array_merge(request(['title', 'body']), [
            'published_at' => $publishedAt
        ]));

        return redirect()->route('dashboard.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $this->validate(request(), [
            'title' => 'required',
            'body' => 'nullable',
            'publication_date' => ['nullable', 'date'],
            'publication_time' => ['nullable', 'required_with:publication_date', 'date_format:H:i']
        ]);

        $publishedAt = null;

        if (! request()->has('unpublish')) {
            if (request()->has('publish')) {
                $publishedAt = Carbon::now();
            } else if (request()->has('publication_date')) {
                $publishedAt = Carbon::parse(vsprintf('%s %s', request([
                    'publication_date', 'publication_time'
                ])));
            }
        }

        $post->update(array_merge(request(['title', 'body']), [
            'published_at' => $publishedAt
        ]));

        return redirect()->route('dashboard.posts.edit', $post);
    }
}
