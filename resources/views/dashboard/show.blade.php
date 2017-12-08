@extends('layouts.dashboard')

@section('content')
    <div class="text-center mt-8">
        <h1 class="mb-4 text-blue text-center">
            Welcome back, {{ auth()->user()->first_name }}
        </h1>

        <h2 class="font-normal mb-6 text-grey w-1/2 mx-auto">
            The full dashboard is coming soon. Until then you can still manage
            your posts.
        </h2>

        <div>
            <a class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" href="{{ route('dashboard.posts.index') }}">
                Go to Posts
            </a>
        </div>
    </div>
@endsection