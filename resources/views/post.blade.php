@extends('layouts.master', ['title' => $post->title])

@section('head')
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@jamesoneill83">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:creator" content="@jamesoneill83">
    <meta name="twitter:description" content="{{ $post->description }}">


    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="blog"/>
    <meta property="og:title" content="{{ $post->title }}"/>
@endsection

@section('content')
    <h1 class="mb3">{{ $post->title }}</h1>
    <div class="post__body">
        {!! $post->body_html !!}
    </div>
@endsection