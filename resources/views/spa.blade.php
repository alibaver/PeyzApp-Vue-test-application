<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Kütüphane ve Dokümantasyon Daire Başkanlığı</title>
    <link rel="icon" href="{{ asset('images/logo/iste_ico.png') }}">

    <!-- Fonts
    <link rel="dns-prefetch" href="//fonts.gstatic.com"> -->

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>


<body>
    <div id="app">
        <div id="topBanner">
            <div class="container py-0 full-height">
                <div class="row py-0 full-height">
                    <div class="col-4 col-sm-4 col-md-4 col-lg-3 d-flex align-items-center p-0">
                        <img src="{{ asset('images/logo/iste_tr.png') }}" alt="İskenderun Teknik Üniversitesi" class="isteLogo" id="isteLogo" />
                    </div>
                    <div class="col-4 col-sm-5 col-md-6 col-lg-5 d-flex align-items-center">
                        <h1 class="isteCaption">Kütüphane ve Dokümantasyon Daire Başkanlığı</h1>
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 col-lg-4 d-flex align-items-center justify-content-center teknoversite">teknoversite</div>
                </div>
            </div>
        </div>

        <app></app>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <script>
        var darkMode = JSON.parse(localStorage.getItem("darkMode"));
    </script>
</body>

</html>