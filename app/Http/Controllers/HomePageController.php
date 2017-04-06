<?php

namespace App\Http\Controllers;

use App\Post;

class HomePageController extends Controller
{
    public function show()
    {
        return view('home', [
            'posts' => Post::orderBy('published_at', 'desc')->get()
        ]);
    }
}
