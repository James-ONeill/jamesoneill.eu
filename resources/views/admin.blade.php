@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">

            @if($drafts->count())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Drafts</h4>
                    </div>

                    <div class="panel-body">
                        @foreach($drafts as $post)
                            <div>
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($scheduledPosts->count())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Scheduled Posts</h4>
                    </div>

                    <div class="panel-body">
                        @foreach($scheduledPosts as $post)
                            <div>
                                {{ $post->published_at->format('d/m/Y') }}
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($recentPosts->count())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Recent Posts</h4>
                    </div>

                    <div class="panel-body">
                        @foreach($recentPosts as $post)
                            <div>
                                {{ $post->published_at->format('d/m/Y') }}
                                {{ $post->title }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection