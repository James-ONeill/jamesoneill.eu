@extends('layouts.master')

@section('header')
    <div class="bg-white shadow border-t-8 border-blue py-2 px-8 text-right mb-8">
        <img class="rounded-full shadow" src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=60">
    </div>
@endsection

@section('main')
    <div class="flex">
        @section('sidebar')
            <nav class="w-64 border-r mr-8 px-8">
                <ul class="list-reset">
                    <li>
                        <a class="text-blue text-lg font-bold" href="{{ route('dashboard.posts.index') }}">
                            Posts
                        </a>
                    </li>
                    <li>
                        <a class="text-blue text-lg font-bold" href="{{ route('dashboard.talks.index') }}">
                            Talks
                        </a>
                    </li>
                </ul>
            </nav>
        @show

        <div class="flex-grow max-w-xl mx-auto">
            @yield('content')
        </div>

        <div class="border-l border-transparent ml-8 px-8 w-64"></div>
    </div>
@endsection