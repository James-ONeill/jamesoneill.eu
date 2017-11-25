<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title or "James O'Neill | Software Developer & Human" }}</title>
        @include('analytics.google')

        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans" rel="stylesheet">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
                <header class="border-t-8 border-blue py-8">
                    <div class="container mx-auto">
                        <img class="rounded-full mb-3" src="https://www.gravatar.com/avatar/{{ md5('james@jamesoneill.eu') }}?s=80">

                        <nav class="font-bold no-underline border-b border-grey text-lg">
                            <ul class="list-reset">
                                @component('components.nav-item', ['url' => route('home')])
                                    Home
                                @endcomponent

                                @component('components.nav-item')
                                    Blog
                                @endcomponent

                                @component('components.nav-item')
                                    Talks
                                @endcomponent
                            </ul>
                        </nav>
                    </div>
                </header>
            @show

            <div class="container mx-auto">
                <h1 class="text-5xl leading-none my-4">
                    Hi, I'm James O'Neill.<br>
                    I'm a software developer.
                </h1>

                <div class="w-2/3">
                    <p class="py-4 leading-normal text-blue-dark">
                        I mainly work on the web and specialise in Laravel and
                        React but I’m interested in all aspects of modern
                        software development and always interested in improving
                        my skills.
                    </p>

                    <p class="py-4 leading-normal text-blue-dark">
                        Write a paragraph about something else.
                    </p>

                    <p class="py-4 leading-normal text-blue-dark">
                        If you like what you’ve read on my site and want to chat
                        then I’d love to hear from you. You could drop me an
                        email at james@jamesoneill.eu or send a tweet to
                        <a href="https://twitter.com/jamesoneill83">@jamesoneill83</a>.
                        If you’re in Bristol and want to talk then it would be
                        great to grab coffee some time.
                    </p>
                </div>
            </div>

            @section('footer')
                <footer class="container mx-auto">
                    <div class="mt-8 border-t py-2">
                        <ul class="list-reset flex justify-center">
                            <li class="px-4">&copy; {{ date('Y') }} James O'Neill</li>
                            |
                            <li class="px-4"><a href="https://twitter.com/jamesoneill83" class="font-normal">Twitter: @jamesoneill83</a></li>
                            |
                            <li class="px-4"><a href="https://github.com/James-ONeill">Twitter: James-ONeill</a></li>
                            |
                            <li class="px-4">RSS</li>
                        </ul>
                    </div>
                </footer>
            @show
        </div>
    </body>
</html>
