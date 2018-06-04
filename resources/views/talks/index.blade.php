@extends('layouts.page')

@section('main')
    <div class="container mx-auto px-4 md:px-0 lg:px-0">
        <h1 class="leading-none my-4 text-3xl">Talks I've Given</h1>

        <ul class="pl-0 md:w-3/4 lg:w-3/4">
            @foreach($talks as $talk)
                <li class="list-reset mb-4">
                    <div class="block mb-1 text-xl">
                        {{ $talk->title }} ({{ $talk->event }})
                    </div>

                    @if($talk->slide_deck_url)
                        <div class="truncate mt-1 mb-6">
                            <a href="{{ $talk->slide_deck_url }}">
                                Slide Deck
                            </a>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endsection