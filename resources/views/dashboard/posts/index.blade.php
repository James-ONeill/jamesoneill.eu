@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.show') }}">
        &#60; Dashboard
    </a>

    <h1 class="mb-8">Manage Posts</h1>

    <div class="bg-white p-8 border-t-4 border-blue rounded shadow">
        @foreach($posts as $post)
            <div class="flex my-4">
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

                <div class="flex px-4 py-2 bg-grey-lighter rounded shadow-inner">
                    <div>
                        <a class="bg-blue block rounded-full shadow text-white mx-1 px-3 py-2 text-center text-xs w-16 hover:no-underline" href="{{ route('dashboard.posts.edit', $post) }}">
                            Edit
                        </a>
                    </div>

                    @published($post)
                        <form action="{{ route('dashboard.published-posts.destroy') }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button class="bg-grey block mx-1 px-3 py-2 rounded-full shadow text-white text-xs w-24 hover:no-underline" type="submit">
                                Unublish
                            </button>
                        </form>
                    @else
                        <form action="{{ route('dashboard.published-posts.store') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button class="bg-blue block mx-1 px-3 py-2 rounded-full shadow text-white text-xs w-24 hover:no-underline" type="submit">
                                Publish
                            </button>
                        </form>
                    @endpublished
                </div>
            </div>
        @endforeach

        <div class="text-right">
            <a class="bg-blue inline-block mt-4 py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" href="{{ route('dashboard.posts.create') }}">
                New Post
            </a>
        </div>
    </div>
@endsection