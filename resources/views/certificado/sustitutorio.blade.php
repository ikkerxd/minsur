<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
    <title>Certifiado de raura Minsur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(0,72,145);">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse flex-grow-1 text-right" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto flex-nowrap">
            <li class="nav-item">
                <a href="{{route('login')}}" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/register') }}" class="nav-link">Registrate</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#">Certificado</a>
            </li>

        </ul>
    </div>
</nav>

<div class="flex-center position-ref full-height">
    <div class="container">
        <div class="row pt-4">
            <div class="col">
                <form action="{{ route('cargardni') }}" method="post" class="form-inline" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="file_up">Archivo</label>
                        <input id="file_up" name="file_up" type="file" accept=".xlsx">
                        <p class="help-block">Subir archivos con formato .xlsx</p>
                    </div>
                    <button class="btn btn-success my-2 my-sm-0" type="submit">CARGAR</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
