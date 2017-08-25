@extends('layouts.master', ['title' => $post->title])

@section('head')
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@jamesoneill83">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:creator" content="@jamesoneill83">
@endsection

@section('content')
    <h1 class="mb3">{{ $post->title }}</h1>
    <div class="post__body">
        {!! $post->markdown() !!}
    </div>
@endsection