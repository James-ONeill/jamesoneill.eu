@extends('layouts.dashboard')

@section('content')
    <form class="form" action="/dashboard/posts" method="POST">
        {!! csrf_field() !!}

        <div class="row">
            <div class="col-sm-8">
                @component('components.panel')
                    <div class="panel-heading">
                        <h4>New Post</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="body" class="control-label">Content</label>
                            <textarea name="body" rows="15" class="form-control">{{ old('body') }}</textarea>
                        </div>
                    </div>
                @endcomponent
            </div>

            <div class="col-sm-4">
                @component('components.panel')
                    <div class="panel-heading">
                        <strong>Publish</strong>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="publication_date" class="control-label">
                                Publication Date
                            </label>

                            <input class="form-control" name="publication_date" id="publication_date" placeholder="{{ date('Y-m-d') }}" value="{{ old('publication_date') }}">
                        </div>

                        <div class="form-group">
                            <label for="publication_time" class="control-label">
                                Publication Time
                            </label>

                            <input class="form-control" name="publication_time" id="publication_time" placeholder="{{ date('H:i') }}" value="{{ old('publication_time') }}">
                        </div>
                    </div>

                    <div class="panel-footer clearfix">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-default">
                                Save
                            </button>

                            <button type="submit" class="btn btn-primary" name="publish" value="true">
                                Save &amp; Publish
                            </button>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    </form>
@endsection
