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

<!-- banner -->
  
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0; margin: 0">

                    <img src="{{ asset('img/ttt.jpeg') }}" class="center-block img-responsive" />

                </div>
                <div class="modal-footer" style="margin-top: 0">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>





<!--end  banner -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script>
        $('#modal-default').modal('show');
    </script>
    @yield('script')

</body>

</html>
