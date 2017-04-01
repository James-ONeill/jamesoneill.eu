<?php

namespace App\Http\Controllers;

use App\Posts;

class HomePageController extends Controller
{
    public function show(Posts $posts)
    {
        return view('home');
    }
}
