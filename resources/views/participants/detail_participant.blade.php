@extends('layouts.templates')

@section('content')

<section class="content-header">
    <h1>
        <i class="fa fa-users"></i> Registro participante
        <small>Version 1.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Participantes</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">


                <div class="box-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">

                                <img src=" {{ asset( 'img/'.$user->image_hash) }} " class="img-responsive center-block">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <table class="table table-striped table-bor dered">
                                <tr>
                                    <td colspan="6">
                                        <h2>{{ $user->name }} {{ $user->firstlastname }} {{ $user->secondlastname }}

                                           <!-- <a data-toggle="tooltip" data-placement="top" title="EDITAR" href="#" class="btn btn-primary pull-right" id="#" style="margin-right: 10px"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>-->

                                            <a data-toggle="tooltip" data-placement="top" title="DESCARGAR FOTOCHECK" href="#" class="btn btn-danger pull-right" style="margin-right: 10px"><i class="fa fa-address-card-o" aria-hidden="true"></i> DESCARGAR FOTOCHECK</a>
                                            <a class="btn btn-primary pull-right" data-target="#solicitar" data-toggle="modal" data-placement="top" title="SOLICITAR FOTOCHECK" style="margin-right: 10px">
                                                <i class="fa fa-address-card-o" aria-hidden="true"></i> SOLICITAR FOTOCHECK
                                            </a>
                                        </h2>
                                </tr>
                                <tr>

                                    <th>DOC. DE IDENTIDAD:</th>
                                    <td>{{ $user->dni }}.</td>

                                    <th>EMPRESA:</th>
                                    <td>{{ $user->businessName }}</td>

                                </tr>

                                <tr>
                                    <th>CARGO:</th>
                                    <td>{{ $user->position }}.</td>
                                    <th>AREA:</th>
                                    <td>{{ $user->superintendence }}.</td>
                                </tr>

                                <tr>
                                    <th>TEELEFONO</th>
                                    <td>{{ $user->phone }}.</td>
                                    <th></th>
                                    <td></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-12">
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
                            <div class="box-footer clearfix">
                                <a href="{{ route('all_certificado', $user->id) }}" class="btn btn-sm btn-default pull-right">DESCARGAR TODOS</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<!--MODAL-->
<div class="modal fade" id="solicitar" role="dialog">
    <<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Requisitos para Solicitar Fotocheck</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4>Debe contar de menera obligarotia con los siguientes datos</h4>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Solicitat Fotocheck</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
</div>
</div>
</div>
<!--MODAL-->
@endsection