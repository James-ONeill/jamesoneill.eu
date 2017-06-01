@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">

            @if($drafts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Drafts</h4>
                    @endslot

                    <div class="panel-body">
                        @foreach($drafts as $post)
                            <div>
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                @endcomponent
            @endif

            @if($scheduledPosts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Scheduled Posts</h4>
                    @endslot

                    <div class="panel-body">
                        @foreach($scheduledPosts as $post)
                            <div>
                                {{ $post->published_at->format('d/m/Y') }}
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                @endcomponent
            @endif

            @if($recentPosts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Recent Posts</h4>
                    @endslot

                    <div class="panel-body">
                        @foreach($recentPosts as $post)
                            <div>
                                {{ $post->published_at->format('d/m/Y') }}
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                @endcomponent
            @endif
        </div>
    </div>
@endsection
