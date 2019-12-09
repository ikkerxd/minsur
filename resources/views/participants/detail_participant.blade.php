@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-search" aria-hidden="true"></i> Detalle Participante
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
                    <div class="box-header with-border">
                            <h3 class="box-title">Participante y lista de cursos.</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <img src="{{ asset('img/avatar04.png') }}" alt="" class="img-responsive center-block">
                            </div>

                            <div class="col-sm-5">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Nombres:</th>
                                        <td>
                                            {{ $user->name }} {{ $user->firstlastname }} {{ $user->secondlastname }}.
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Doc. de identidad:</th>
                                        <td>{{ $user->dni }}.</td>
                                    </tr>
                                    <tr>
                                        <th>Empresa:</th>
                                        <td>{{ $user->businessName }}.</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="col-sm-5">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Cargo:</th>
                                        <td>{{ $user->position }}.</td>
                                    </tr>
                                    <tr>
                                        <th>Area:</th>
                                        <td>{{ $user->superintendence }}.</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Curso</th>
                                        <th>Fecha</th>
                                        <th>Nota</th>
                                        <th>Estado</th>
                                        <th>Vigente</th>
                                        <th>Certificado</th>


                                        <!--<th>Aprovado</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($result as $element)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $element->course }}</td>
                                            <td>{{ $element->date }}</td>
                                            <td>{{ $element->point }}</td>
                                            @if($element->aprobado)
                                                <td class="text-green">aprobado</td>
                                            @else
                                                <td class="text-red">deaprobado</td>
                                            @endif

                                            <td>{{ $element->vigencia }}</td>
                                            @if($element->aprobado)
                                                <td><a href="{{ route('certificado', $element->id) }}" class="btn btn-primary btn-xs">Certficado</a></td>
                                            @else
                                                <td>No tiene</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer clearfix">
                        <a href="{{ route('all_certificado', $user->id) }}" class="btn btn-sm btn-default pull-right">DESCARGAR TODOS</a>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

