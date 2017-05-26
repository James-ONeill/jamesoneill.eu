@extends('layouts.dashboard')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>New Post</h4>
        </div>

        <div class="panel-body">
            <form class="form" action="{{ route('dashboard.posts.update', $post) }}" method="POST">
                {!! csrf_field() !!}
                {!! method_field('PUT') !!}

                <div class="form-group">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="body" class="control-label">Content</label>
                    <textarea name="body" rows="15" class="form-control">{{ old('body', $post->body) }}</textarea>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary btn-lg pull-right">
                        Save Post
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection