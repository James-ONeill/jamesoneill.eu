<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>James O'Neill</title>
    </head>

    <body>
        @section('header')
            <header class="header">
                <h1 class="header__title">James O'Neill</h1>
            </header>
        @endsection

        <main>
            @yield('content')
        </main>
    </body>
</html>