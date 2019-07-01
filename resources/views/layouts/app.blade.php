<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        /*body {
            background: url(img/cover/cover.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            padding-top: 70px;
        }*/

    </style>
</head>
<body>
    <div id="app">
        <header class="header">
            <div class="header-container">
                <nav class="main-nav">
                    <ul class="main-menu">
                        <li class="main-menu__item">
                            <a href="{{route('login')}}" class="main-menu__link">Login</a>
                        </li>
                        <li class="main-menu__item">
                            <a href="{{ url('/register') }}" class="main-menu__link">Registrate</a>
                        </li>
                        <li class="main-menu__item">
                            <a href="{{ route('certificate_search') }}" class="main-menu__link">Certificado</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="banner">
            <img src="{{ asset('img/cover/cover.jpg') }}" alt="banner" class="banner__img">
            <div class="banner__data">
            @yield('content')
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    @yield('script')
</body>
</html>
