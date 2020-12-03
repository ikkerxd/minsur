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
                            <h3>Solicutes de Fotocheck</h3>
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
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Luis Medina Rondon</td>
                                        <td>2020-11-27</td>
                                        <td><span class="label label-success">Apronado</span></td>
                                        <td>
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-check-square-o"></i> Ver</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Enrique Medina Medina</td>
                                        <td>2020-11-20</td>
                                        <td><span class="label label-danger">Rechazado</span></td>
                                        <td>
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-check-square-o"></i> Detalle</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Hernan Medina Alfaro</td>
                                        <td>2020-11-21</td>
                                        <td><span class="label label-warning">Pendiente</span> </td>
                                        <td>
                                        <button type="button" class="btn btn-secondary"><i class="fa fa-check-square-o"></i> Ver</button>
                                        </td>
                                    </tr>
                                    
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