@extends('layouts.dashboard')

@section('content')
    @component('components.panel')
        <div class="panel-heading">
            <h4>Posts</h4>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>
                        Published
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>
                            <strong>{{ $post->title }}</strong>
                        </td>
                        <td>
                            {{ $post->publication_status }}
                        </td>
                        <td>
                            <a href="{{ route('dashboard.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endcomponent
@endsection
