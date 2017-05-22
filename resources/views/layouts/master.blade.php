<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>James O'Neill</title>
        @include('analytics.google')

        <link rel="stylesheet" type="text/css" href="/css/app.css">
    </head>

    <body>
        <div class="container">
            @section('header')
                <header class="header">
                    <div class="text-center">
                        <img class="gravatar"  src="https://www.gravatar.com/avatar/{{ md5('james@levelupdevelopment.co.uk') }}?s=80">
                    </div>

                    <h1 class="header__title text-center">
                        <a href="/">James O'Neill</a>
                    </h1>
                </header>
            @show

            <main>
                @yield('content')
            </main>

            @section('footer')
                <footer class="main-footer text-center">
                    <p class="main-footer__copyright">
                        &copy; James O'Neill
                        2017
                        @if(date('Y') > 2017)
                            {{ date('- Y') }}
                        @endif
                    </p>
                </footer>
            @show
        </div>
    </body>
</html>