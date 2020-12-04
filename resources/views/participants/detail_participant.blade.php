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

                @if ( Session::has('success') )
                    <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="fa fa-check" aria-hidden="true"></i> {{ Session::get('success') }}
                </div>
                @endif
                @if ( Session::has('danger') )
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <i class="fa fa-ban" aria-hidden="true"></i> {{ Session::get('danger') }}
                </div>
                @endif
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
                <h3 class="modal-title text-center">Requisitos para Solicitar Fotocheck</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <form action="{{ route('fotocheck.solicited') }}"
                    method="POST" id="formCourse">
                    {{ csrf_field() }}
            <div class="modal-body">
                <p><strong>Capacitación y entrenamiento para ser líder de aislamiento (dictado por el supervisor).                       Presentar registro de capacitación y exámen (nota mínima 16).
                    Mínimo 1 hora de capacitación.</strong></p>
                    <hr>
                <p><strong>Vigía de excavaciones y zanjas (capacitación por parte del supervisor): Primeros auxilios 1 hora (registro y exámen)    (nota mínima 16)
                    Protocolo de actuación en caso de emergencia en los trabajos de excavaciones 1 hora (resgistro y exámen) (nota mínima 16). Mínimo 1 hora de capacitación.  </strong></p>
                    <hr>
                <p><strong>Presentar: Certificado de operador de grúa y Rigger. PIC que especifique el equipo que operará. Vigía de izaje con grúas 
                    (capacitación por parte del supervisor 1 hora)-presentar regsitro de capacitación y exámen (nota mínima 16).Mínimo 1 hora de capacitación.</strong></p>
                    <hr>
                <h5><strong>CURSO INFORMATIVO</strong></h5>
                    <hr>
                <p><strong>Certificado de operación del equipo o capacitación.Para el caso de capacitación presentar registro de capacitación y exámen. (nota mínima 16). Mínimo 1 hora de capacitación.  </strong></p>
                    <hr>
                <p><strong>Capacitación de voladura realizada por el jefe de voladura (presentar exámen y registro- nota mínima 16). Carnet de la SUCAMEC vigente (COPIA)     </strong></p>
                    <hr>
                <p><strong>Capacitacion y entrenamiento (identificación de la incompatibilidad de los reactivos químicos en el área. Presentar registro y exámen (nota mínima 18).
                    Los conductores que transportarán materiales peligrosos dentro y fuera de la UM, deben contar con la licencia de conducir del MTC de caregoría especial A4. Mínimo 1 hora de capacitación.</strong></p>
                    <hr>
                <p><strong>Certificado de suficiencia médica (copia).</strong></p>
                    <hr>
                <p><strong>Soldador homologado (validado en el perfil del puesto)   - presentar certificado o evidencia (correo) Vigía de fuego: 
                    Presentar registro de capacitación y exámen (nota mínima 18) en uso y manipulación de extintores - dictada por el supervisor. Mínimo 1 hora de capacitación.</strong></p>
                    <hr>
                <p><strong>Solicitar autorización con lista de herramientas a usar. Presentar registro de capacitación y exámen (nota mínima 18)  de cada herramienta de poder - dictada por el supervisor operativo. 
                    Mínimo 1 hora de capacitación.</strong></p>
                    <hr>
                <p><strong>Capacitación por el jefe de área. Presentar registro de capacitación y exámen. (nota mínima 20) Mínimo 4 hora de capacitación.</strong></p>
                    <hr>

                <input  name="user_id" class="hidden" value="{{$user->id}}" >
                <h5><strong>Debe contar con Foto de Perfil</strong></h5>
                <hr>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Solicitar Fotocheck</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
            </form>
            </div>
        </div>
</div>
</div>
</div>
<!--MODAL-->
@endsection