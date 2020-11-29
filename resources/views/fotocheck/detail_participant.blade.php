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
                                                    LUIS MEDINA RONDON
                                                    <a class="btn btn-primary pull-right" data-target="#solicitar1" data-toggle="modal" data-placement="top" title="SOLICITAR FOTOCHECK" style="margin-right: 10px">
                                                        <i class="fa fa-user-time" aria-hidden="true"></i> RECHAZAR SOLICITUD
                                                    </a>
                                                </h3>
                                        </tr>
                                        <tr>

                                            <th>Doc. de Identidad:</th>
                                            <td>88888888</td>

                                            <th>Empresa:</th>
                                            <td>IGH PERU</td>

                                        </tr>

                                        <tr>
                                            <th>Cargo:</th>
                                            <td>Asistente Programado</td>
                                            <th>Area:</th>
                                            <td>Sistemas</td>
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
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>IPERC</td>
                                        <td>2020-11-28</td>
                                        <td>16</td>
                                        <td> <span class="label label-success"> Vigente</span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>NIRIIPAT</td>
                                        <td>2020-11-28</td>
                                        <td>16</td>
                                        <td> <span class="label label-success"> Vigente</span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>ANEXO 4</td>
                                        <td>2020-11-28</td>
                                        <td>16</td>
                                        <td> <span class="label label-success"> Vigente</span></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success"> <i class="far fa-save"></i> Guardar </button>
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