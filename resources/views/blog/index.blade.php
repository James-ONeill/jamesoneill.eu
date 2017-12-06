@extends('layouts.page')

@section('content')
    <div class="container mx-auto px-4 md:px-0 lg:px-0">
        <h1 class="leading-none my-4 text-3xl">Articles I've Written</h1>

        <ul class="pl-0 md:w-3/4 lg:w-3/4">
            @foreach($posts as $post)
                <li class="list-reset mb-4">
                    <a href="{{ $post->url() }}" class="block mb-1 text-xl">
                        {{ $post->title }}
                    </a>

                    <div class="text-sm text-grey-darker mb-3">
                        {{ $post->published_at->format('jS F Y') }}
                    </div>

                    <p class="truncate mt-1 mb-6">{{ $post->description }}</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection