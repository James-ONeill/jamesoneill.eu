<?php

namespace App\Http\Controllers\Dashboard;

use App\Talk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedTalksController extends Controller
{
    public function store()
    {
        $talk = Talk::findOrFail(request('talk_id'));

        if ($talk->is_published) {
            abort(422);
        }

        $talk->publish();

        return redirect()->route('dashboard.talks.index');
    }

    public function destroy()
    {
        $talk = Talk::findOrFail(request('talk_id'));

        if (! $talk->is_published) {
            abort(422);
        }

        $talk->unpublish();

        return redirect()->route('dashboard.talks.index');
    }
}
