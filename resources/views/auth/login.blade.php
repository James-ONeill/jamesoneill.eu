@extends('layouts.master', ['bodyClass' => 'bg-grey-lightest border-t-8 border-blue font-sans h-screen'])

@section('content')
    <div class="flex flex-col h-full items-center justify-center">
        <h1 class="mb-1 text-blue text-center">Dashboard</h1>
        <h2 class="font-normal mb-6 text-center text-grey">Sign in to manage the site</h2>

        <form class="bg-white {{ $errors->has('email') ? 'border-red-lighter' : 'border-blue'}} border-t-4 px-6 py-8 rounded shadow w-3/4 sm:w-2/3 md:w-1/2 lg:w-1/4" action="{{ route('auth.login') }}" method="POST">
            {!! csrf_field() !!}
            {!! $errors->first('email', '<p class="mb-6 mt-0 text-center text-red-light text-sm">:message</p>') !!}
            <input class="border-none bg-grey-lightest block mb-4 px-4 py-3 shadow w-full" name="email" placeholder="Email Address" type="text">
            <input class="border-none bg-grey-lightest block mb-6 px-4 py-3 shadow w-full" name="password" placeholder="Password" type="password">
            <button class="bg-blue block p-3 rounded-full shadow text-white w-full" type="submit">Login</button>
        </form>
    </div>
@endsection