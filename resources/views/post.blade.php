@extends('layouts.master')

@section('content')
    <h1>{{ $post->title }}</h1>
    <div class="post__body">
        {!! $post->markdown() !!}
    </div>
@endsection