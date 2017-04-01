<?php

namespace App\Http\Controllers;

use App\Post;

class BlogController extends Controller
{
    public function show($year, $month, $day, $title)
    {
        $post = Post::where('slug', str_slug($title))->firstOrFail();

        return view('post', ['post' => $post]);
    }
}
