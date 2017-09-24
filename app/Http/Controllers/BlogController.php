<?php

namespace App\Http\Controllers;

use App\Post;

class BlogController extends Controller
{
    /**
     * Show a single blog post.
     *
     * @param  string|int  $year
     * @param  string|int  $month
     * @param  string|int  $day
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($year, $month, $day, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('post', ['post' => $post]);
    }
}
