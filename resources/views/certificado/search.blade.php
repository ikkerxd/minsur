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
                <form action="{{ route('certificate_search') }}" method="post" class="form-inline">
                    {{ csrf_field() }}
                    <input name="doc" class="form-control mr-sm-3" type="search" placeholder="Ingrese su Documento" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" type="submit">BUSCAR</button>
                </form>
            </div>

        </div>
        <div class="row pt-4">
            <div class="col">
                <h4 style="color: rgb(174,17,34);">LISTA DE CERTIFICADOS</h4>
            </div>
        </div>
        <hr style="background-color: rgb(205,50,67);">
        <div class="row pt-3">
            <div class="col">
                <table class="table table-sm table-bordered" id="datatable">
                    <thead style="background-color: rgb(0,72,145); color: #fff">
                    <tr>
                        <th>#</th>
                        <th>Partcipante</th>
                        <th>Curso</th>
                        <th>Valido Desde</th>
                        <th>Valido Hasta</th>
                        <th>Certificado</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cursos as $curso)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <th>{{ $curso->firstlastname }} {{ $curso->secondlastname }} {{ $curso->name  }}</th>
                            <th>{{ $curso->curso }}</th>
                            <td>{{ $curso->start }}</td>
                            <td>{{ $curso->end }}</td>
                            <td><a href="{{ route('certificado', $curso->id) }}" class="btn btn-sm btn-outline-success">certificado</a></td>
                        </tr>
                    @empty
                        <th>
                        <td colspan="5">No tiene ningun certificado.</td>
                        </th>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</body>
</html>
