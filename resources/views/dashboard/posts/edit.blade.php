@extends('layouts.dashboard')

@section('content')
    <form class="form"
        action="{{ route('dashboard.posts.update', $post) }}"
        method="POST"
        enctype="multipart/form-data">

        {!! csrf_field() !!}
        {!! method_field('PUT') !!}

        <div class="row">
            <div class="col-sm-8">
                @component('components.panel', ['heading' => 'Edit Post'])
                    <div class="panel-body">
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.

                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @component('components.form-group', ['name' => 'title'])
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" value="{{ old('title', $post->title) }}" class="form-control">
                        @endcomponent

                        @component('components.form-group', ['name' => 'body'])
                            <label for="body" class="control-label">Content</label>
                            <textarea name="body" rows="15" class="form-control">{{ old('body', $post->body) }}</textarea>
                        @endcomponent
                    </div>
                @endcomponent
            </div>

            <div class="col-sm-4">
                @component('components.panel', ['heading' => 'Thumbnail Image'])
                    <div class="panel-body">
                        @if($post->thumbnail_url)
                            <div class="form-group">
                                <img src="{{ $post->thumbnail_url }}" alt="Current Thumbnail"  class="img-responsive">
                            </div>
                        @endif

                        @component('components.form-group', ['name' => 'thumbnail'])
                            <input type="file" name="thumbnail">
                        @endcomponent
                    </div>
                @endcomponent

                @component('components.panel', ['heading' => 'Publish'])
                    @slot('footer')
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
                    @endslot
                @endcomponent
            </div>
        </div>
    </form>
@endsection
