@extends('layouts.master')

@section('content')
    <h1 class="mb3">{{ $post->title }}</h1>
    <div class="post__body">
        {!! $post->markdown() !!}
    </div>
@endsection