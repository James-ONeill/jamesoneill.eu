@extends('layouts.dashboard')

@section('content')
    <form class="form" action="{{ route('dashboard.posts.update', $post) }}" method="POST">
        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach

        <div class="row">
            <div class="col-sm-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>New Post</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="body" class="control-label">Content</label>
                            <textarea name="body" rows="15" class="form-control">{{ old('body', $post->body) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Publish</strong>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="publication_date" class="control-label">
                                Publication Date
                            </label>

                            <input class="form-control" name="publication_date" id="publication_date" placeholder="{{ date('Y-m-d') }}" value="{{ old('publication_date', $post->publication_date) }}">
                        </div>

                        <div class="form-group">
                            <label for="publication_time" class="control-label">
                                Publication Time
                            </label>

                            <input class="form-control" name="publication_time" id="publication_time" placeholder="{{ date('H:i') }}" value="{{ old('publication_time', $post->publication_time) }}">
                        </div>
                    </div>

                    <div class="panel-footer clearfix">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-default">
                                Save
                            </button>

                            @if($post->published)
                                <button type="submit" class="btn btn-danger" name="unpublish" value="true">
                                    Unpublish
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary" name="publish" value="true">
                                    Publish
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection