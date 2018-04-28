@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.posts.index') }}">
        &#60; Posts
    </a>

    <h1 class="mb-1">Create New Post</h1>

    <div class="text-grey-darker text-lg mb-8">
        Draft
    </div>

    <form action="{{ route('dashboard.posts.store') }}" method="POST">
        {!! csrf_field() !!}

        <post-editor></post-editor>
    </form>
@endsection