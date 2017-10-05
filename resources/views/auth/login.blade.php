@extends('layouts.dashboard')

@section('content')
    <div class="login-container">
        <h1 class="heading">Dashboard Login</h1>
        <h2 class="subheading">Enter your login credentials to manage the site</h2>

        <login-form :errors="{{ $errors->count() }}">
            {!! csrf_field() !!}
        </login-form>
    </div>
@endsection
