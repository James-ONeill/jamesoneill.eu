@extends('layouts.dashboard')

@section('content')
    <a class="text-grey-darker text-md mb-2 block hover:no-underline" href="{{ route('dashboard.show') }}">
        &#60; Dashboard
    </a>

    <h1 class="mb-8">Manage Talks</h1>

    <div class="bg-white p-8 border-t-4 border-blue rounded shadow">
        @foreach($talks as $talk)
            <div class="flex my-4">
                <div class="flex-grow">
                    <h1 class="mb-1 text-xl">{{ $talk->title }}</h1>
                    <div class="text-grey-darker text-blue text-sm">
                        @published($talk)
                            Published on {{ $talk->published_at->format('d/m/Y \a\t h:i') }}
                        @else
                            Draft
                        @endpublished
                    </div>
                </div>

                <div class="flex px-4 py-2 bg-grey-lighter rounded shadow-inner">
                    <div>
                        <a class="border-2 border-blue bg-blue block rounded-full shadow text-white mx-1 px-3 py-2 text-center text-xs w-16 hover:no-underline" href="{{ route('dashboard.talks.edit', $talk) }}">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-right">
            <a class="bg-blue inline-block mt-4 py-3 px-6 rounded-full shadow text-white w-auto hover:no-underline" href="{{ route('dashboard.talks.create') }}">
                New Talk
            </a>
        </div>
    </div>
@endsection