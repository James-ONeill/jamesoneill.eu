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
                    <a class="block bg-blue rounded-full text-white mx-1 px-3 py-2 text-sm hover:no-underline shadow" href="{{ route('dashboard.posts.edit', $post) }}">
                        Edit
                    </a>
                </div>

                @published($post)
                    <form action="{{ route('dashboard.published-posts.destroy') }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class="block bg-grey rounded-full text-white mx-1 px-3 py-2 text-sm hover:no-underline shadow" type="submit">
                            Unublish
                        </button>
                    </form>
                @else
                    <form action="{{ route('dashboard.published-posts.store') }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button class="block bg-blue rounded-full text-white mx-1 px-3 py-2 text-sm hover:no-underline shadow" type="submit">
                            Publish
                        </button>
                    </form>
                @endpublished
            </div>
        @endforeach

        <div class="text-right">
            <a class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" href="{{ route('dashboard.posts.create') }}">
                New Post
            </a>
        </div>
    </div>
@endsection