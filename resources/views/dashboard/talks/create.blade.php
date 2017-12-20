@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.talks.index') }}">
        &#60; Talks
    </a>

    <h1 class="mb-1">Create New Talk</h1>

    <div class="text-grey-darker text-lg mb-8">
        Draft
    </div>

    <form action="{{ route('dashboard.talks.store') }}" method="POST">
        {!! csrf_field() !!}

        <div class="bg-white {{ $errors->count() ? 'border-red' : 'border-blue'}} border-t-4 px-6 py-8 rounded shadow">
            @foreach($errors->all() as $error)
                <p class="mb-6 mt-0 text-red-light text-base">{{ $error }}</p>
            @endforeach

            <label class="block font-bold mb-2" for="title">Title</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="title" value="{{ old('title') }}">

            <label class="block font-bold mb-2" for="event">Event</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="event" value="{{ old('event') }}">

            <label class="block font-bold mb-2" for="event">Slide Deck URL</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="slide_deck_url" value="{{ old('slide_deck_url') }}">

            <label class="block font-bold mb-2" for="event">Video URL</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="video_url" value="{{ old('video_url') }}">

            <div class="text-right">
                <button class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" type="submit">
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection