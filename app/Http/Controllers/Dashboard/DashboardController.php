<?php

namespace App\Http\Controllers\Dashboard;

use App\Post;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin', [
            'recentPosts' => Post::published()->orderBy('published_at', 'DESC')->take(10)->get(),
            'scheduledPosts' => Post::scheduled()->orderBy('published_at', 'DESC')->take(10)->get(),
            'drafts' => Post::unscheduled()->orderBy('published_at', 'DESC')->take(10)->get()
        ]);
    }
}
