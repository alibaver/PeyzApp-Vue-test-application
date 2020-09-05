<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
    <link rel="icon" href="{{ asset('images/logo/iste_ico.png') }}">

    <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com"> -->

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>


<body>
    <div id="app">
        <app></app>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <script>
        var darkMode = JSON.parse(localStorage.getItem("darkMode"));
    </script>
</body>

</html>