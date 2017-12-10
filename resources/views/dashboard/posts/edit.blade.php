@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.posts.index') }}">
        &#60; Posts
    </a>

    <h1 class="mb-1">{{ $post->title }}</h1>

    <div class="text-grey-darker text-lg mb-8">
        @published($post)
            {{ $post->published_at->format('d/m/Y h:i') }}
        @else
            Draft
        @endpublished
    </div>

    <form action="{{ route('dashboard.posts.update', $post) }}" method="POST">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        <div class="bg-white shadow border-t-4 {{ $errors->count() ? 'border-red' : 'border-blue'}} px-6 py-8 rounded">
            @errors
                @foreach($errors->all() as $error)
                    <p class="mb-6 mt-0 text-red-light text-base">{{ $error }}</p>
                @endforeach
            @enderrors

            <label class="block font-bold mb-2" for="title">Title</label>
            <input class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full" type="text" name="title" value="{{ old('title', $post->title) }}">

            <textarea class="border-none bg-grey-lightest block mb-8 px-4 py-3 shadow w-full resize-none font-mono leading-loose tracking-wide" name="body" rows="30">{{ old('body', $post->body) }}</textarea>

            <div class="text-right">
                <button class="bg-blue inline-block py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" type="submit">
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection