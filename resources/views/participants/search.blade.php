@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-search" aria-hidden="true"></i> Participante
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Buscar Participante</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-sm-12">
                            <h3 class="box-title">Buscar Participante</h3>
                        </div>
                        <br>
                        <br>
                        <!--<div class="col-sm-4">
                            {!! Form::open(['route' => 'search-participant','method' => 'GET', 'class' => 'form-search', 'role'=>'search']) !!}
                            <div class="input-group input-group-sm">
                                {!! Form::text('dni', null, ['class' => 'form-control', 'placeholder' => 'Ingrese Doc. identidad']) !!}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                                </span>
                            </div>
                            {!! Form::close() !!}
                        </div> -->
                        <br>
                        <div class="col-sm-12">
                            <table class="table table-bordered text-center" id="datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DNI</th>
                                    <th>Nombres</th>
                                    <th>Empresa</th>
                                    <th>Condicion</th>
                                    <th>Cursos</th>
                                    <th>bloquear</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->dni }}</td>
                                        <td>{{ $user->firstlastname }} {{ $user->secondlastname }} {{ $user->name }}</td>
                                        <td>{{ $user->empresa }}</td>
                                        <td>
                                            @if ($user->state == 0)
                                                Activo
                                            @else
                                                Inactivo
                                            @endif
                                        </td>
                                        <td><a href="{{ route('detail-participant', $user->id) }}" class="btn btn-xs btn-primary">Consolidado</a></td>
                                        <td>
                                            <form action="" method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-xs btn-danger">Anular</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table> <!-- tabla-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable({
                "stateSave": true,
                "processing": true,
            });
        });
    </script>
@endsection