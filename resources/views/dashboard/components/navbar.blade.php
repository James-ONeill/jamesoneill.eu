<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/">
                        HOME
                    </a>
                </li>

                @if(auth()->check())
                    <li>
                        <a href="/dashboard">
                            DASHBOARD
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            POSTS
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="/dashboard/posts">All Posts</a></li>
                            <li><a href="/dashboard/posts/new">New Post</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            @if(auth()->check())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown">
                            <img src="https://www.gravatar.com/avatar/64e1c29b55bf5db4b04c65f552ddb474?s=35" height="35" width="35" class="navbar-avatar">
                            James O'Neill
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="/logout" id="logout">
                                    {!! csrf_field() !!}
                                </form>

                                <a href="#" onClick="document.getElementById('logout').submit()">
                                    Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
