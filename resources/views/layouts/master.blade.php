<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title or "James O'Neill | Software Developer & Human" }}</title>
        @include('analytics.google')

        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/github-gist.min.css">
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/utilities.css') }}">

        @yield('head')
    </head>

    <body>
        @section('header')
            <header class="header border-t bw4 bc-red pt4 mb4">
                <div class="container text-center">
                    <img class="gravatar rounded" src="https://www.gravatar.com/avatar/{{ md5('james@levelupdevelopment.co.uk') }}?s=80">
                    <h1><a href="/" class="tdn gray2 hover:gray2 hover:tdn">James O'Neill</a></h1>
                    <a style="font-size: 30px" href="{{ url('/feed') }}"><i class="fa fa-rss"></i></a>
                    <a style="font-size: 30px" href="https://twitter.com/jamesoneill83"><i class="fa fa-twitter"></i></a>
                    <a style="font-size: 30px" href="https://github.com/James-ONeill"><i class="fa fa-github"></i></a>
                </div>
            </header>
        @show
        <div class="container">
            <main class="constrain-lg mh-auto">
                @yield('content')
            </main>

            @section('footer')
                <div class="constrain-lg mh-auto">
                    <footer class="border-t bc-gray1 pt4 mt4 text-center">
                        <p class="main-footer__copyright">
                            &copy; James O'Neill
                            2017
                            @if(date('Y') > 2017)
                                {{ date('- Y') }}
                            @endif
                        </p>
                    </footer>
                </div>
            @show
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
        <script>hljs.initHighlightingOnLoad();</script>
    </body>
</html>
