@extends('layouts.master')

@section('content')
    <p class="text-grey-darkest my-3 text-sm">I'm a software developer from Bristol in the South West of England.</p>

    <p class="text-grey-darkest my-3 text-sm">
        Day to day I mostly work with Laravel and React. This site is your
        source of information for whatever I happen to be up to, be it related
        to software or any of my other interests.
    </p>

    <p class="text-grey-darkest my-3 text-sm">
        If you want to say hi why not follow me on
        <a class="text-red no-underline" href="https://twitter.com/jamesoneill83">Twitter</a> or you can drop
        me an email at <a class="text-red no-underline" href="mailto:james@jamesoneill.eu">james@jamesoneill.eu</a>.
        Also you could <a class="text-red no-underline" href="https://www.facebook.com/ambertibetanterrier/">like my Dog on Facebook.</a>
    </p>

    <div class="my-8">
        @if($posts->count())
            <ul class="list-reset mx-0 my-3">
                @foreach($posts as $post)
                    <li class="list-reset my-3">
                        <div class="my-0 text-sm text-grey-dark">{{ $post->published_at->format('jS F Y') }}</div>
                        <h2 class="my-0 text-red">
                            <a class="no-underline text-black" href="{{ $post->url() }}">{{ $post->title }}</a>
                        </h2>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <mailing-list-signup />
@endsection
