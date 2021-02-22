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
                        <h3 class="box-title">Reportes de pagos por empresa de la UM </h3>
                    </div>
                  
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

                        <div class='col-md-3'>
                            <div class="form-group">
                                {!! Form::label('id_location', 'Unidad Minera') !!}
                                <select name="id_location" id="id_location" class="form-control" >
                                         <option value="#">Selecciones Unidad Minera</option>
                                          <option value="1">UM San rafael</option>
                                          <option value="2">UM Pucamarca</option>
                                          <option value="3">UM Pisco</option>
                                          <option value="4">AESA </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="submit" name="action" value="read" class="btn bg-primary" style=" position: relative;top: 21.5px;">Buscar</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <a type="submit" name="action" value="read" class="btn bg-green " style=" position: relative;top: 21.5px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Datos</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
                </div>
            </div>
        </div>
    </section>

    

@endsection
@section('script')
<script>
    $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
</script>
            
@endsection