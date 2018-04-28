@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.posts.index') }}">
        &#60; Posts
    </a>

    <h1 class="mb-1">{{ $post->title }}</h1>

    <div class="text-grey-darker text-lg mb-8">
        @published($post)
            {{ $post->published_at->format('d/m/Y h:i') }}
        @else
            Draft
        @endpublished
    </div>

    <form action="{{ route('dashboard.posts.update', $post) }}" method="POST">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        <post-editor :post="{{ $post }}"></post-editor>
    </form>
@endsection