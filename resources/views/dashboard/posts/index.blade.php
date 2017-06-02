@extends('layouts.dashboard')

@section('content')
    @component('components.panel')
        <div class="panel-heading">
            <h4>Posts</h4>
        </div>

        @include('dashboard.posts.table')
    @endcomponent
@endsection
