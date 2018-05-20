@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.posts.index') }}">
        &#60; Posts
    </a>

    <form action="{{ route('dashboard.posts.update', $post) }}" method="POST">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        <post-editor :post="{{ $post }}"></post-editor>
    </form>
@endsection