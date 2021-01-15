@extends('layouts.templates')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Fotocheck
        <small>Version 1.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Fotocheck</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.message')
            <div class="box">
                <div class="box-body">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Participante y Lista de cursos</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">

                                        <img src=" {{asset( 'img/'.$fotocheck->user->image_hash)}} " class="img-responsive center-block">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <table class="table table-striped table-bor dered">
                                        <tr>
                                            <td colspan="6">
                                                <h3>
                                                    {{$fotocheck->user->full_name}}
                                                    
                                                </h3>
                                        </tr>
                                        <tr>

                                            <th>Doc. de Identidad:</th>
                                            <td>{{$fotocheck->user->dni}}</td>

                                            <th>Empresa:</th>
                                            <td>{{$fotocheck->user->company->businessName}}</td>

                                        </tr>

                                        <tr>
                                            <th>Cargo:</th>
                                            <td>{{$fotocheck->user->position}}</td>
                                            <th>Area:</th>
                                            <td>{{$fotocheck->user->superintendence}}</td>
                                        </tr>

                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Fecha Vencimiento </th>
                                        <th scope="col">Nota</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$detail->inscription->course->id .'---'.$detail->inscription->course->name}}</td>
                                        <td>{{$detail->inscription->startDate}}</td>
                                        <td>{{$detail->vigency()}}</td>
                                        <td>{{$detail->point}}</td>
                                        @if($detail->vigencyState())
                                        <td> <span class="label label-primary">Solicitado</span></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('fotocheck.accept', $fotocheck->id) }}" class="btn btn-primary"><i class="far fa-save"></i>Aceptar Solicitud</a>
                            <a href="{{ route('fotocheck.cancel', $fotocheck->id) }}" class="btn btn-primary"><i class="far fa-save"></i>Rechazar Solicitud</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

@endsection