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
                                            <a class="btn btn-primary pull-right" href="{{route('fotochecks.index',$user->id)}}" data-placement="top" title="SOLICITAR FOTOCHECK" style="margin-right: 10px">
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
                                            <td>{{$element->course }}</td>
                                            <td>{{ $element->date }}</td>
                                            <td>{{ $element->point }}</td>
                                            @if($element->aprobado)
                                                <td class="text-green">aprobado</td>
                                            @else
                                                <td class="text-red">deaprobado</td>
                                            @endif

                                            <td>{{ $element->vigencia }}</td>
                                            @if($element->aprobado == '1' and \Carbon\Carbon::now() <= \Carbon\Carbon::parse($element->vigencia))
                                                <td>
                                                    <a href="{{ route('certificado', $element->id) }}" class="btn btn-primary btn-xs">
                                                        Certificado
                                                    </a>
                                                </td>
                                            @elseif($element->aprobado == '1' and \Carbon\Carbon::now() > \Carbon\Carbon::parse($element->vigencia))
                                                <td>Vencido</td>
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
</div>
@endsection