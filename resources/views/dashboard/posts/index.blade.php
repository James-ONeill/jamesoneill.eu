@extends('layouts.dashboard')

@section('content')
    <div class="bg-white p-8 border-t-4 border-blue rounded shadow">
        @foreach($posts as $post)
            <div class="flex my-3">
                <div class="flex-grow">
                    <h1 class="mb-1 text-xl">{{ $post->title }}</h1>
                    <div class="text-grey-darker text-blue text-sm">
                        @published($post)
                            Published on {{ $post->published_at->format('d/m/Y \a\t h:i') }}
                        @else
                            Draft
                        @endpublished
                    </div>
                </div>


                <div>
                    <a class="block bg-blue rounded-full text-white px-3 py-2 text-sm hover:no-underline shadow" href="{{ route('dashboard.posts.edit', $post) }}">
                        Edit
                    </a>
                </div>
            </div>
        @endforeach

        <div class="text-right">
            <a class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" href="{{ route('dashboard.posts.create') }}">
                New Post
            </a>
        </div>
    </div>
@endsection