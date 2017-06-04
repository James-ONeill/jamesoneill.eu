<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
    <script src="/js/app.js"></script>
</head>
<body>
    @include('dashboard.components.navbar')

    <div class="container">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <p class="footer-text">&copy; James O'Neill {{ date('Y') }} </p>
        </div>
    </footer>
</body>
