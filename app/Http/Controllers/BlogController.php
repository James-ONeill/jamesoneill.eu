<?php

namespace App\Http\Controllers;

use App\Posts;

class BlogController extends Controller
{
    protected $posts;

    public function __construct(Posts $posts)
    {
        $this->posts = $posts;
    }

    public function show($year, $month, $day, $title)
    {
        if ($content = $this->posts->get($year, $month, $day, $title)) {
            return view('post', ['content' => $content]);
        }

        return abort(404);
    }
}
