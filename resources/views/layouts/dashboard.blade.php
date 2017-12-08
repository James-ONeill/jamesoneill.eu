@extends('layouts.master')

@section('header')
    <div class="bg-white shadow border-t-8 border-blue py-2 px-8 text-right mb-8">
        <img class="rounded-full shadow" src="https://www.gravatar.com/avatar/{{ md5(auth()->user()->email) }}?s=60">
    </div>
@endsection

@section('main')
    <div class="container mx-auto">
        @yield('content')
    </div>
@endsection