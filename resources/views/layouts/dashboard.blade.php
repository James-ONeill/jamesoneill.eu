<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="/css/admin.css">
    <script src="/js/app.js"></script>
</head>
<body>
    @include('dashboard.components.navbar')

    <div class="container">
        @yield('content')
    </div>
</body>