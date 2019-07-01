
@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-building-o" aria-hidden="true"></i> Reporte Pagos
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Reportes de pagos por empresa</h3>
                    </div>
                    {!! Form::open(['route' => 'report_company']) !!}
                    <div class="box-body">


                        <div class='col-md-3'>
                            <div class="form-group">
                                {!! Form::label('startDate', 'Fecha de inicio') !!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('startDate', null, ['class' => 'form-control pull-right datepicker','required' => 'required','autocomplete' => 'off']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                {!! Form::label('endDate', 'Fecha de fin') !!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('endDate', null, ['class' => 'form-control pull-right datepicker','required' => 'required','autocomplete' => 'off']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn bg-primary" style=" position: relative;top: 21.5px;">Buscar</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-default">
                    <hr>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ruc</th>
                                <th>Empresa</th>
                                <th>Id usuario</th>
                                <th>Curso</th>
                                <th>Horas</th>
                                <th>Fecha</th>
                                <th>Forma de pago</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($companies as $company)

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <th>{{ $company->ruc }}</th>
                                        <td>{{ $company->businessName }}</td>
                                        <td>{{ $company->id_user }}</td>
                                        <td>{{ $company->nameCurso  }}</td>
                                        <td>{{ $company->hours }}</td>
                                        <td>{{ $company->startDate }}</td>
                                        <td>{{ $company->payment_form }}</td>
                                    </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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