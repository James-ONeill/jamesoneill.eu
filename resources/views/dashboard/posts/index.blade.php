@extends('layouts.dashboard')

@section('content')
    <div class="bg-white p-8 border-t-4 border-blue rounded shadow">
        @foreach($posts as $post)
            <div class="flex py-1">
                <h2 class="flex-grow">{{ $post->title }}</h2>

                <div class="text-grey-darker px-6 text-sm">
                    @published($post)
                        {{ $post->published_at->format('d/m/Y h:i') }}
                    @else
                        Draft
                    @endpublished
                </div>

                <a class="block bg-blue rounded-full text-white px-3 py-2 text-sm hover:no-underline" href="{{ route('dashboard.posts.edit', $post) }}">Edit</a>
            </div>
        @endforeach
    </div>
@endsection