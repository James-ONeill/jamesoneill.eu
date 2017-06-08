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
                    <a href="{{ route('dashboard.posts.edit', $post) }}" class="btn btn-primary btn-sm">
                        Edit
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
