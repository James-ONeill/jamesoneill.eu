@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.posts.index') }}">
        &#60; Posts
    </a>

    <form action="{{ route('dashboard.posts.store') }}" method="POST">
        {!! csrf_field() !!}

        <post-editor></post-editor>
    </form>
@endsection