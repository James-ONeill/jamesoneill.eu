@extends('layouts.dashboard')

@section('main')
    <div class="bg-white mb-16 py-3 shadow -mt-8">
        <div class="flex items-center max-w-xl mx-auto">
            <div class="flex-grow mr-4">
                <h1 class="bg-transparent font-bold px-6 py-2 rounded text-3xl text-blue transition-300 w-full">
                    Manage Posts
                </h1>
            </div>
            <div class="mr-2">
                <a class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline focus:no-outline" href="{{ route('dashboard.posts.create') }}">
                    New Post
                </a>
            </div>
        </div>
    </div>

    <div class="flex mb-8">
        <div class="flex flex-wrap max-w-xl mx-auto">
            @foreach($posts as $post)
                <div class="mb-4 px-2 w-1/3">
                    <post-card :post="{{ $post }}"></post-card>
                </div>
            @endforeach
        </div>
    </div>
@endsection