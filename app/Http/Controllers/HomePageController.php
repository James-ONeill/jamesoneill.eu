<?php

namespace App\Http\Controllers;

use App\Post;

class HomePageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $posts = Post::published()->orderBy('published_at', 'desc')->get();

        return view('home', ['posts' => $posts]);
    }
}
