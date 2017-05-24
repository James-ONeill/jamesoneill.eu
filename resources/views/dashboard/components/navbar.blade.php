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
                    <a href="#" data-toggle="dropdown">
                        <img src="https://www.gravatar.com/avatar/64e1c29b55bf5db4b04c65f552ddb474?s=35" height="35" width="35" class="navbar-avatar">
                        James O'Neill
                        <b class="caret"></b>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="logout" id="logout">
                                {!! csrf_field() !!}
                            </form>

                            <a href="#" onClick="document.getElementById('logout').submit()">
                                Log Out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>