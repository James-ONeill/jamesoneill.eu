@extends('layouts.master')

@section('header')
    <dashboard-navbar :user="{{ auth()->user() }}"></dashboard-navbar>
@endsection

@section('main')
    <div class="flex mb-8">
        <div class="flex-grow max-w-xl mx-auto">
            @yield('content')
        </div>
    </div>
@endsection