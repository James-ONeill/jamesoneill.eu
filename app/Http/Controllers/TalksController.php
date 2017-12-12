<?php

namespace App\Http\Controllers;

use App\Talk;
use Illuminate\Http\Request;

class TalksController extends Controller
{
    public function index()
    {
        return view('talks.index', [
            'talks' => Talk::published()->orderBy('published_at', 'DESC')->get()
        ]);
    }
}
