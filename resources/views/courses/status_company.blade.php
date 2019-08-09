
@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> status compañia.
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Contrata</li>
            <li class="active">Asistencia</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <div>
                            @if($companies != [])
                                <a href="{{ route('export_status_company') }}"
                                   class="btn btn-success btn-sm pull-right">
                                    <i class="fa fa-download"></i> Exportar Status Compañia
                                </a>
                                <a href="{{ route('export_status_list_company') }}"
                                   class="btn btn-primary btn-sm pull-right">
                                    <i class="fa fa-download"></i> Exportar Lista de Participantes
                                </a>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="box-body table-responsive">
                        @include('layouts.info')
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>AREA</th>
                                <th>TOTAL DE PERSONAL</th>
                                <th>CANTIDAD DE PERSONAS QUE ASISTIERON Y APROBARON</th>
                                <th>CANTIDAD DE PERSONAS QUE FALTARON  O DESPAROBARON</th>
                                <th>PORCENTAJE DE CUMPLIMENTO</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($companies as $company)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $company->area }}</td>
                                    <td>{{ $company->total }}</td>
                                    <td>{{ $company->aprobados }}</td>
                                    <td>{{ $company->desaprobados }}</td>
                                    <td>{{ $company->porcentaje }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No hay curso obligatorio en la presente fecha</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
