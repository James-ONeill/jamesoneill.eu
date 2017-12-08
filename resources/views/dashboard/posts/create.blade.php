@extends('layouts.dashboard')

@section('content')
    <h1 class="mb-1">Create New Post</h1>
    <div class="text-grey-darker text-lg mb-8">
        Draft
    </div>

    <form action="{{ route('dashboard.posts.store') }}" method="POST">
        {!! csrf_field() !!}

        <div class="bg-white shadow border-t-4 {{ $errors->count() ? 'border-red' : 'border-blue'}} px-6 py-8 rounded">
            @errors
                @foreach($errors->all() as $error)
                    <p class="mb-6 mt-0 text-red-light text-base">{{ $error }}</p>
                @endforeach
            @enderrors

            <label class="block font-bold mb-2" for="title">Title</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="title" value="{{ old('title') }}">

            <textarea class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full resize-none font-mono leading-loose tracking-wide" name="body" rows="30">{{ old('body') }}</textarea>

            <div class="text-right">
                <button class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" type="submit">
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection