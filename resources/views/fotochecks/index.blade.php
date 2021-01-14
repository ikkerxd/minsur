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
                            <h3>Solicitudes de Fotocheck</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped" >
                                <thead >
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Participante</th>
                                        <th scope="col">Fecha de solicitud</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Solicitudes</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach($fotochecks as $fotocheck)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$fotocheck->user->full_name}}</td>
                                        <td>{{$fotocheck->updated_at}}</td>
                                        <td><span class="badge label-success">Pendiente</span></td>
                                        <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('fotocheck.detail',$fotocheck)}}" ><i class="fa fa-check-square-o"></i> Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection