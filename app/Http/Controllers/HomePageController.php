<?php

namespace App\Http\Controllers;

use App\Post;

class HomePageController extends Controller
{
    public function show()
    {
        return view('home', ['posts' => Post::all()]);
    }
}
