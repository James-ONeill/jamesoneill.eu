<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="/js/app.js"></script>
</head>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            POSTS
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">New Post</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">
                            PAGES
                            <b class="caret"></b>
                        </a>
                    </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#">
                            <img src="https://www.gravatar.com/avatar/64e1c29b55bf5db4b04c65f552ddb474?s=35" height="35" width="35" class="navbar-avatar">
                            James O'Neill
                            <b class="caret"></b>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
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
    </div>
</body>
</html>