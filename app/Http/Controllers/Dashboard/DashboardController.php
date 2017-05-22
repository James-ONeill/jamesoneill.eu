<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $posts = Post::published()->orderBy('published_at', 'DESC')->take(10)->get();

        return view('admin', [
            'posts' => $posts
        ]);
    }
}
