@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Drafts</h4>
                </div>

                <div class="panel-body">
                    Panel body.
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Scheduled Posts</h4>
                </div>

                <div class="panel-body">
                    Panel body.
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Recent Posts</h4>
                </div>

                <div class="panel-body">
                    @foreach($posts as $post)
                        <div>
                            {{ $post->published_at->format('d/m/Y') }}
                            {{ $post->title }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection