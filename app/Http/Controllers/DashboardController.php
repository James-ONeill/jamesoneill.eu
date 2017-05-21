<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {
        $posts = Post::published()->orderBy('published_at', 'DESC')->take(10)->get();

        return view('admin', [
            'posts' => $posts
        ]);
    }
}
