@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">

            @if($drafts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Drafts</h4>
                    @endslot

                    @include('dashboard.posts.table', ['posts' => $drafts])
                @endcomponent
            @endif

            @if($scheduledPosts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Scheduled Posts</h4>
                    @endslot

                    @include('dashboard.posts.table', ['posts' => $scheduledPosts])
                @endcomponent
            @endif

            @if($recentPosts->count())
                @component('components.panel')
                    @slot('heading')
                        <h4>Recent Posts</h4>
                    @endslot

                    @include('dashboard.posts.table', ['posts' => $recentPosts])
                @endcomponent
            @endif
        </div>
    </div>
@endsection
