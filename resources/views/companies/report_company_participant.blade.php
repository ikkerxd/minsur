
@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-building-o" aria-hidden="true"></i> Reporte Empresa Participante
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Empresas</li>
        </ol>
    </section>

    <section class="content" style="min-height: auto">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="width: 100%">
                            Empresa:
                            <strong>{{ $name_company }}</strong> del
                            <strong>{{ $start }}</strong> hasta <strong>{{ $end }}</strong>
                            <span class=" pull-right">
                                @if($invoice)
                                    <a href="{{ route('invoice-valorizacion', [$invoice->id]) }}" class="btn btn-sm btn-info"><i class="fa fa-file-excel-o"></i> Valorizacion</a>
                                @endif

                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-money"></i> Facturar
                                    </button>

                                <a href="{{ route('export_company_participant',[ $id_user_inscription,$start,$end]) }}"
                                class="btn btn-success btn-sm">
                                    <i class="fa fa-download"></i> Exportar
                                </a>
                            </span>
                        </h3>
                    </div>

                    <div class="box-body table-responsive">
                        @include('layouts.info')
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DNI</th>
                                <th>AP Paterno</th>
                                <th>AP Materno</th>
                                <th>Nombres</th>
                                <th>Area</th>
                                <th>Curso</th>
                                <th>fecha</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($query as $participant)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>{{ $participant->dni }}</th>
                                    <td>{{ $participant->firstlastname }}</td>
                                    <td>{{ $participant->secondlastname }}</td>
                                    <td>{{ $participant->name }}</td>
                                    <td>{{ $participant->superintendence }}</td>
                                    <td>{{ $participant->nameCurso }}</td>
                                    <td>{{ $participant->startDate }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Registar factura de <strong>{{ $name_company }}</strong> del mes de <strong>{{ $mes }}</strong></h4>
                    </div>
                    <form action="{{ route('invoice-contrata')}}" enctype="multipart/form-data" method="post" >
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <input type="hidden" name="start" value="{{ $start }}">
                            <input type="hidden" name="end" value="{{ $end }}">
                            <input type="hidden" name="idUserInscription" value="{{ $id_user_inscription }}">
                            <input type="hidden" name="cobros" value="{{ $cobros}}">
                            <input type="hidden" name="horas" value="{{ $horas}}">
                            <div class="form-group">
                                <label for="nro-factura" class="control-label">Nro. de factura:</label>
                                <input type="text" name="nroFactura" class="form-control" id="nro-factura">
                                <p class="help-block text-blue">El factura sera omitida para el mes de <strong>{{ $mes }}</strong></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-light-blue btn-sm">Guardar</button>
                        </div>

                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                "stateSave": true,
                "processing": true,
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>
@endsection