
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
                        <h3 class="box-title">Reportes de pagos por empresa de la UM {{ strtoupper($unity->name) }}</h3>
                    </div>
                    {!! Form::open(['route' => ['companies_um', $id_um]]) !!}
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
                                <button type="submit" name="action" value="read" class="btn bg-primary" style=" position: relative;top: 21.5px;">Buscar</button>
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
                                <th>Email de valorizacion</th>
                                <th>Telefono</th>
                                <th>Total horas</th>
                                <th>Total cobros</th>
                                <th>Monto</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($query as $company)

                                <tr  class="{{ ($company->horas == null || $company->cobros == null) ? '' : ((($company->horas != $company->total_horas) || ($company->cobros != $company->total_cobros)) ? 'danger' : '' ) }} {{ $company->cobros }} {{ $company->total_cobros }} "
                                     data-id="{{ $company->id }}"
                                    data-company="{{ $company->codigo_company }}"
                                    data-observation = "{{ $company->observation }}"
                                    data-state = "{{ $company->state }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $company->ruc }}</td>
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
                                    <td>{{ $company->total_horas }}</td>
                                    <td>{{ $company->total_cobros }}</td>
                                    <td>{{ $company->monto_cobros }}</td>
                                    <td style="white-space: nowrap">
                                        @if($company->process === 1)
                                            <div>
                                                @if($company->state === '2')
                                                    <button type="button" class="btn btn-primary btn-sm btn-fac" data-toggle="modal" data-target="#myModalFact"
                                                            rel="tooltip" data-placement="top" title="Valorizacion Observada" disabled>
                                                        <i class="fa fa-inbox"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-primary btn-sm btn-fac" data-toggle="modal" data-target="#myModalFact"
                                                            rel="tooltip" data-placement="top" title="Facturar">
                                                        <i class="fa fa-inbox"></i>
                                                    </button>
                                                @endif
                                                <a href="{{ route('invoice-valorizacion', [$company->id]) }}" class="btn btn-success btn-sm btn-exp" data-toggle="tooltip" data-placement="top" title="Descargar">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </a>

                                                @if($company->state === '2')
                                                    <button type="button" class="btn btn-warning btn-sm btn-obs" data-toggle="modal" data-target="#myModalObs"
                                                            rel="tooltip" data-placement="top" title="Levantar observacion">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm btn-obs" data-toggle="modal" data-target="#myModalObs"
                                                            rel="tooltip" data-placement="top" title="Observar">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @endif



                                                <button type="button" class="btn btn-danger btn-sm btn-del" data-toggle="modal" data-target="#myModalDel"
                                                        rel="tooltip" data-placement="top" title="Anular">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                        @elseif($company->process === 2)

                                            <div>
                                                @if($company->state == 2)
                                                    <button type="button" class="btn btn-info btn-sm btn-fac" data-toggle="modal" data-target="#myModalPaid"
                                                            rel="tooltip" data-placement="top" title="observacion en la facturacion" disabled>
                                                        <i class="fa fa-money"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-sm btn-fac" data-toggle="modal" data-target="#myModalPaid"
                                                            rel="tooltip" data-placement="top" title="Pagar">
                                                        <i class="fa fa-money"></i>
                                                    </button>
                                                @endif

                                                <a href="{{ route('invoice-valorizacion', [$company->id]) }}" class="btn btn-success btn-sm btn-exp" data-toggle="tooltip" data-placement="top" title="Descargar">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </a>
                                                @if($company->state == 2)
                                                    <button type="button" class="btn btn-warning btn-sm btn-obs" data-toggle="modal" data-target="#myModalObs"
                                                            rel="tooltip" data-placement="top" title="Levantar observacion">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm btn-obs" data-toggle="modal" data-target="#myModalObs"
                                                            rel="tooltip" data-placement="top" title="Observar">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-danger btn-sm btn-del" data-toggle="modal" data-target="#myModalDel"
                                                        rel="tooltip" data-placement="top" title="Anular">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                        @elseif($company->process === 3)
                                            <div>
                                                <span><i class="fa fa-check-circle fa-2x" style="color: #00a65a"></i></span>
                                            </div>
                                        @else
                                            <button type="button" class="btn btn-default btn-sm btn-val" data-toggle="modal" data-target="#myModalVal"
                                                    rel="tooltip" data-placement="top" title="Valorizar">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                               <!-- <a href="#" class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Eliminar"><i class="fa fa-trash"></i></a>-->
                                    </td>
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

    <div class="modal fade" id="myModalVal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Valorizacion de : <span class="nameConpamy">empresa 1</span></h4>
                </div>

                {!! Form::open(['route' => ['companies_um', $id_um], 'class' => 'form-inline', 'id' => 'form_val']) !!}

                    <div class="modal-body">

                        <div class="box-process">
                            <div class="box-process__border--val">
                                <div class="box-process__val"><i class="fa fa-check fa-2x"  aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <input type="hidden" class="id_invoice" name="invoice">
                        <input type="hidden" id="id_company" name="company">
                        <input type="hidden" id="id_unity" name="unity" value="{{ $id_um }}">
                        <input type="hidden" id="start" name="startDate" value="{{ $start }}">
                        <input type="hidden" id="end" name="endDate" value="{{ $end }}">
                        <input type="hidden" id="cobros" name="cobros">
                        <input type="hidden" id="horas" name="horas">
                        <input type="hidden" name="action" value="val">

                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit"  class="btn btn-primary btn_submit_proccess">Si</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalFact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Factura(s) de: <span class="nameConpamy">empresa 1</span></h4>
                </div>

                {!! Form::open(['route' => ['companies_um', $id_um], 'class' => 'form-inline', 'id' => 'form_fact']) !!}

                <div class="modal-body">

                    <div class="box-process">
                        <div class="box-process__border--fac">
                            <div class="box-process__fac"><i class="fa fa-inbox fa-2x"  aria-hidden="true"></i></div>
                        </div>
                    </div>

                        <div class="group-fact">
                            <input type="text" name="factura" placeholder="Nro: Factura(s)" class="form-control" required>
                            <input type="url" name="url" placeholder="Ingrese URL" class="form-control" required autocomplete="off">
                        </div>

                    <input type="hidden" id="start" name="startDate" value="{{ $start }}">
                    <input type="hidden" id="end" name="endDate" value="{{ $end }}">
                    <input type="hidden" class="id_invoice" name="invoice">
                    <input type="hidden" name="action" value="fact">

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit"  class="btn btn-primary btn_submit_proccess">Si</button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalPaid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Pagar factura(s) de: <span class="nameConpamy">empresa 1</span></h4>
                </div>

                {!! Form::open(['route' => ['companies_um', $id_um], 'class' => 'form-inline', 'id' => 'form_paid']) !!}

                <div class="modal-body">

                    <div class="box-process">
                        <div class="box-process__border--paid">
                            <div class="box-process__paid"><i class="fa fa-money fa-3x"  aria-hidden="true"></i></div>
                        </div>
                    </div>

                    <input type="hidden" id="start" name="startDate" value="{{ $start }}">
                    <input type="hidden" id="end" name="endDate" value="{{ $end }}">
                    <input type="hidden" class="id_invoice" name="invoice">
                    <input type="hidden" name="action" value="paid">

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit"  class="btn btn-info btn_submit_proccess">Si</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalObs" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Observar a: <span class="nameConpamy">empresa 1</span></h4>
                </div>

                {!! Form::open(['route' => ['companies_um', $id_um], 'class' => 'form-inline', 'id' => 'form_obs']) !!}

                <div class="modal-body">
                    <div class="box-process">
                        <div class="box-process__border--obs">
                            <div class="box-process__obs"><i class="fa fa-eye-slash fa-3x"  aria-hidden="true"></i></div>
                        </div>
                    </div>

                    <div class="group-fact">
                        <textarea name="observation" placeholder="descripción de la observación" class="form-control id_observation" required rows="8"></textarea>
                    </div>

                    <input type="hidden" id="start" name="startDate" value="{{ $start }}">
                    <input type="hidden" id="end" name="endDate" value="{{ $end }}">
                    <input type="hidden" class="id_invoice" name="invoice">
                    <input type="hidden" name="action" value="obs">

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit"  class="btn btn-warning btn_submit_proccess observation">Si</button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Anular proceso de: <span class="nameConpamy">empresa 1</span></h4>
                </div>

                {!! Form::open(['route' => ['companies_um', $id_um], 'class' => 'form-inline', 'id' => 'form_del']) !!}

                <div class="modal-body">

                    <div class="box-process">
                        <div class="box-process__border--del">
                            <div class="box-process__del"><i class="fa fa-times fa-3x"  aria-hidden="true"></i></div>
                        </div>
                    </div>

                    <input type="hidden" id="start" name="startDate" value="{{ $start }}">
                    <input type="hidden" id="end" name="endDate" value="{{ $end }}">
                    <input type="hidden" class="id_invoice" name="invoice">
                    <input type="hidden" name="action" value="del">
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit"  class="btn btn-danger btn_submit_proccess">Si</button>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $("[rel='tooltip']").tooltip();

            $('#datatable').DataTable({
                "stateSave": true,
                "processing": true,
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });

            $('#datatable tbody').on('click', 'tr .btn-val',  function (e) {
                e.preventDefault();
                // Recuperamos toda la columna
                const row = $(this).parents('tr');
                console.log(row.children('td:nth-child(3)').text());
                const empresa = row.children('td:nth-child(3)').text();
                $('.nameConpamy').html(empresa);
                const id_company = row.data('company');
                const  id_invoice = row.data('id');
                console.log(row.data('id'));
                $('#id_company').val(id_company);
                $('.id_invoice').val(id_invoice);
                $('#cobros').val(row.children('td:nth-child(7)').text());
                $('#horas').val(row.children('td:nth-child(6)').text());
                console.log(id_company, id_invoice);
                // console.log(nameCompany);
            });
            $('#datatable tbody').on('click', 'tr .btn-fac',  function (e) {
                e.preventDefault();
                // Recuperamos toda la columna
                const row = $(this).parents('tr');
                const empresa = row.children('td:nth-child(3)').text();
                $('.nameConpamy').html(empresa);
                const  id_invoice = row.data('id');
                $('.id_invoice').val(id_invoice);
            });

            $('#datatable tbody').on('click', 'tr .btn-paid',  function (e) {
                e.preventDefault();
                // Recuperamos toda la columna
                const row = $(this).parents('tr');
                const empresa = row.children('td:nth-child(3)').text();
                $('.nameConpamy').html(empresa);
                const  id_invoice = row.data('id');
                $('.id_invoice').val(id_invoice);
            });

            $('#datatable tbody').on('click', 'tr .btn-obs',  function (e) {
                e.preventDefault();
                // Recuperamos toda la columna
                const row = $(this).parents('tr');
                const empresa = row.children('td:nth-child(3)').text();
                $('.nameConpamy').html(empresa);
                const  state = row.data('state');
                if(state == 2) {
                    $('.observation').text('Levantar Observacion');
                } else {
                    $('.observation').text('Si');
                }
                const  id_invoice = row.data('id');
                const  id_observation = row.data('observation');
                $('.id_observation').val(id_observation);
                $('.id_invoice').val(id_invoice);
            });

            $('#datatable tbody').on('click', 'tr .btn-del',  function (e) {
                e.preventDefault();
                // Recuperamos toda la columna
                const row = $(this).parents('tr');
                const empresa = row.children('td:nth-child(3)').text();
                $('.nameConpamy').html(empresa);
                const  id_invoice = row.data('id');
                $('.id_invoice').val(id_invoice);
            });

            $('#form_val').submit(function(){
                $('.btn_submit_proccess').prop('disabled',true);
                $('.btn_submit_proccess').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"></span> ...');
            });
            $('#form_fact').submit(function(){
                $('.btn_submit_proccess').prop('disabled',true);
                $('.btn_submit_proccess').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"></span> ...');
            });
            $('#form_paid').submit(function(){
                $('.btn_submit_proccess').prop('disabled',true);
                $('.btn_submit_proccess').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"></span> ...');
            });
            $('#form_obs').submit(function(){
                $('.btn_submit_proccess').prop('disabled',true);
                $('.btn_submit_proccess').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"></span> ...');
            });
            $('#form_del').submit(function(){
                $('.btn_submit_proccess').prop('disabled',true);
                $('.btn_submit_proccess').html('<i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"></span> ...');
            });
        });
    </script>
@endsection