
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
                    @if($query)
                        <div class="box-header">
                            <div class="box-tools pull-right">
                                <a href="{{ route('export_consolidado', [Auth::id(), Request::get('startDate'), Request::get('endDate')]) }}" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Consolidado general</a>
                            </div>
                        </div>
                        <br>
                        <br>
                    @endif
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ruc</th>
                                <th>Empresa</th>
                                <th>Email de valorizacion</th>
                                <th>Telefono</th>
                                <th>Total horas</th>
                                <th>Total cobros</th>
                                <th>Monto</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($query as $company)

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>{{ $company->ruc }}</th>
                                    <td>

                                        <a href="{{route(
                                        'report_company_participant',
                                        [$company->id_user_inscription.'/'.Request::get('startDate').'/'.Request::get('endDate')] ) }}"
                                        >
                                            {{ $company->businessName }}
                                        </a>
                                    </td>
                                    <td>{{ $company->email_valorization }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->horas }}</td>
                                    <td>{{ $company->total_cobros }}</td>
                                    <td>{{ $company->monto_cobros }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua">
                                        <i class="fa fa-building"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Empresas</span>
                                        <span class="info-box-number">{{ $count_company }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-yellow">
                                        <i class="ion ion-clock"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Horas</span>
                                        <span class="info-box-number">{{ $total_horas }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-red">
                                        <i class="ion ion-bonfire"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Cobros</span>
                                        <span class="info-box-number">{{ $total_cobros }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="info-box">
                                    <span class="info-box-icon bg-olive">
                                        <i class="ion ion-cash"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Monto Total</span>
                                        <span class="info-box-number">{{ $monto_total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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