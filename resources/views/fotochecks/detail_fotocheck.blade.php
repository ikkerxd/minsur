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

                                        <img src=" {{ asset( 'img/avatar5.png') }} " class="img-responsive center-block">
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
                                        <th scope="col">Fecha Vencimiento </th>
                                        <th scope="col">Nota</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($details as $detail)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$detail->inscription->course->name}}</td>
                                        <td>{{$detail->vigency($detail)}}</td>
                                        <td>{{$detail->point}}</td>
                                        <td> <span class="label label-success"> Vigente</span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success"> <i class="far fa-save"></i> Aprobar Solicitud </button>
                            <button type="button" class="btn btn-primary"> <i class="far fa-save"></i> Rechazar Solicitud </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!--MODAL-->
<div class="modal fade" id="solicitar1" role="dialog">
    <<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Rechazar Solicitud</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descrpción de rechazo</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
</div>
</div>
</div>
<!--MODAL-->
@endsection