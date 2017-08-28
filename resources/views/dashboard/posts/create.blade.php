@extends('layouts.dashboard')

@section('content')
    <form class="form" action="/dashboard/posts" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-sm-8">
                @component('components.panel')
                    @slot('heading')
                        New Post
                    @endslot

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
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                        @endcomponent

                        @component('components.form-group', ['name' => 'body'])
                            <label for="body" class="control-label">Content</label>
                            <textarea name="body" rows="15" class="form-control">{{ old('body') }}</textarea>
                        @endcomponent
                    </div>
                @endcomponent
            </div>

            <div class="col-sm-4">
                @component('components.panel', ['heading' => 'Thumbnail Image'])
                    <div class="panel-body">
                        @component('components.form-group', ['name' => 'thumbnail'])
                            <input type="file" name="thumbnail">
                        @endcomponent
                    </div>
                @endcomponent

                @component('components.panel', ['heading' => 'Publish'])
                    <div class="panel-body">
                        @component('components.form-group', ['name' => 'publication_date'])
                            <label for="publication_date" class="control-label">
                                Publication Date
                            </label>

                            <input class="form-control" name="publication_date" id="publication_date" placeholder="{{ date('Y-m-d') }}" value="{{ old('publication_date') }}">
                        @endcomponent

                        @component('components.form-group', ['name' => 'publication_time'])
                            <label for="publication_time" class="control-label">
                                Publication Time
                            </label>

                            <input class="form-control" name="publication_time" id="publication_time" placeholder="{{ date('H:i') }}" value="{{ old('publication_time') }}">
                        @endcomponent
                    </div>

                    @slot('footer')
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-default">
                                Save
                            </button>

                            <button type="submit" class="btn btn-primary" name="publish" value="true">
                                Save &amp; Publish
                            </button>
                        </div>
                    @endslot
                @endcomponent
            </div>
        </div>
    </form>
@endsection
