@extends('layouts.dashboard')

@section('content')
    <div class="text-center mt-8">
        <h1 class="mb-4 text-blue text-center">
            Welcome back, {{ auth()->user()->first_name }}
        </h1>

        <h2 class="font-normal text-grey w-1/2 mx-auto">
            The full dashboard is coming soon. Until then you can still manage
            your posts.
        </h2>

        <div class="flex mt-8">
            <div class="px-4 w-1/2">
                <div class="border-t-4 border-blue p-4 bg-white rounded shadow">
                    <h2 class="text-lg text-blue">Articles</h2>

                    <a href="{{ route('dashboard.posts.index') }}">
                        Manage Articles
                    </a>

                    <a href="{{ route('dashboard.posts.create') }}">
                        New Article
                    </a>
                </div>
            </div>

            <div class="px-4 w-1/2">
                <div class="border-t-4 border-blue p-4 bg-white rounded shadow">
                    <h2 class="text-lg text-blue">Talks</h2>

                    <a href="{{ route('dashboard.talks.index') }}">
                        Manage Talks
                    </a>

                    <a href="{{ route('dashboard.talks.create') }}">
                        New Talk
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection