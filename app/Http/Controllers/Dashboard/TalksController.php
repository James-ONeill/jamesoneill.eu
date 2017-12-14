<?php

namespace App\Http\Controllers\Dashboard;

use App\Talk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TalksController extends Controller
{
    public function create()
    {
        return view('dashboard.talks.create');
    }

    public function store()
    {
        $params = request()->validate([
            'title' => 'required',
            'event' => 'nullable',
            'slide_deck_url' => 'nullable',
            'video_url' => 'nullable',
        ]);

        $talk = Talk::create($params);

        return redirect('/dashboard/talks');
    }
}
