@extends('layouts.master')

@section('content')

    <p>I'm a software developer from Bristol in the South West of England.</p>

    <p>
        Day to day I mostly work with Laravel and React. This site is your
        source of information for whatever I happen to be up to, be it related
        to software or any of my other interests.
    </p>

    <p>
        If you want to say hi why not follow me on
        <a href="https://twitter.com/jamesoneill83">Twitter</a> or you can drop
        me an email at <a href="mailto:james@jamesoneill.eu">james@jamesoneill.eu</a>.
        Also you could <a href="https://www.facebook.com/ambertibetanterrier/">like my Dog on Facebook.</a>
    </p>

    <mailing-list-signup></mailing-list-signup>

    @if($posts->count())
        <ul class="lsn mt4 pl0">
            @foreach($posts as $post)
                <li class="blog-post mb2">
                    <div>{{ $post->published_at->format('jS F Y') }}</div>
                    <h2 class="mv0">
                        <a class="gray2 hover:gray2" href="{{ $post->url() }}">{{ $post->title }}</a>
                    </h2>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
