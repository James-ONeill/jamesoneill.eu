<table class="table">
    <thead>
        <tr>
            <th>
                Title
            </th>
            <th>
                Status
            </th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($posts as $post)
            <tr>
                <td>
                    <strong class="text-red">{{ $post->title }}</strong>
                </td>
                <td>
                    {{ $post->publication_status }}
                </td>
                <td>
                    <div class="btn-group">
                    @published($post)
                        <form method="POST" action="{{ route('dashboard.posts.unpublish', $post) }}">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button type="submit" class="btn btn-default">Unublish post</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('dashboard.posts.publish') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <button type="submit" class="btn btn-default">Publish post</button>
                        </form>
                    @endpublished
                        <a href="{{ route('dashboard.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
