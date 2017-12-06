<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title or "Dashboard" }}</title>

        @include('analytics.google')

        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/github-gist.min.css">
        <link rel="stylesheet" type="text/css" href="{{ mix('/css/main.css') }}">

        @yield('head')

        <script defer src="{{ mix('/js/app.js') }}"></script>

        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

        <script defer src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
        <script defer>hljs.initHighlightingOnLoad();</script>
    </head>

    <body class="font-sans bg-grey-lightest">
        <div id="app">
            @section('header')
                <header class="border-t-8 border-blue pt-8 mb-8">
                    <div class="container mx-auto px-4 md:px-0 lg:px-0">

                        <div class="text-center md:text-left lg:text-left">
                            <img class="rounded-full mb-3 box-shadow-1" src="https://www.gravatar.com/avatar/{{ md5('james@jamesoneill.eu') }}?s=80">
                        </div>

                        <nav class="border-b border-grey font-bold no-underline text-lg">
                            <ul class="flex list-reset">
                                @component('components.nav-item', ['url' => route('home')])
                                    Home
                                @endcomponent

                                @component('components.nav-item', ['url' => route('blog')])
                                    Blog
                                @endcomponent
                                {{--
                                @component('components.nav-item')
                                    Talks
                                @endcomponent
                                --}}
                            </ul>
                        </nav>
                    </div>
                </header>
            @show

            @yield('content')

            @section('footer')
                <footer class="container mx-auto px-4 md:px-0 lg:px-0">
                    <div class="mt-8 border-t py-8 border-grey">
                        <ul class="list-reset flex flex-col md:flex-row lg:flex-row justify-center items-center">
                            <li class="px-4 text-grey-darker md:text-grey-darkest lg:text-grey-darkest text-sm md:text-base lg:text-base mb-2 md:mb-0 lg:mb-0">
                                &copy; {{ date('Y') }} James O'Neill
                            </li>

                            <span class="hidden md:inline lg:inline">|</span>

                            <li class="px-4">
                                <a href="https://twitter.com/jamesoneill83">Twitter</a>
                            </li>

                            <span class="hidden md:inline lg:inline">|</span>

                            <li class="px-4">
                                <a href="https://github.com/James-ONeill">Github</a>
                            </li>

                            <span class="hidden md:inline lg:inline">|</span>

                            <li class="px-4"><a href="/feed">RSS</a></li>

                            <span class="hidden md:inline lg:inline">|</span>

                            <li class="px-4 mt-2 md:mt-0 lg:mt-0 text-grey-darker md:text-grey-darkest lg:text-grey-darkest">
                                Hosted on <a href="https://m.do.co/c/312253772b44">Digital Ocean</a>
                            </li>
                        </ul>
                    </div>
                </footer>
            @show
        </div>
    </body>
</html>
