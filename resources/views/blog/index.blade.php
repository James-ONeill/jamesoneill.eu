@extends('layouts.master')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl leading-none my-4">Articles I've Written</h1>

        <ul class="pl-0 w-3/4">
            @foreach($posts as $post)
                <li class="list-reset mb-4">
                    <a href="{{ $post->url() }}" class="block mb-1 text-xl">
                        {{ $post->title }}
                    </a>

                    <div class="text-sm text-grey-darker mb-3">{{ $post->published_at->format('jS F Y') }}</div>
                    <p>{{ $post->description }}</p>
                </li>
            @endforeach
        </ul>
    </div>
@endsection