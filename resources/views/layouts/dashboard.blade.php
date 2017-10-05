<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
    <script src="/js/app.js" defer></script>
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
