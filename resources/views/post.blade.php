@extends('layouts.page', ['title' => $post->title])

@section('head')
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@jamesoneill83">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:creator" content="@jamesoneill83">
    <meta name="twitter:description" content="{{ $post->description }}">
    <meta name="twitter:image" content="{{ $post->thumbnail }}">

    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="blog"/>
    <meta property="og:title" content="{{ $post->title }}"/>
    <meta property="og:description" content="{{ $post->description }}">
    <meta property="og:image" content="{{ $post->thumbnail }}">
@endsection

@section('content')
    <main class="container mx-auto px-4 md:px-0 lg:px-0">
        <h1 class="mb-3">{{ $post->title }}</h1>
        {!! $post->body_html !!}
    </main>
@endsection