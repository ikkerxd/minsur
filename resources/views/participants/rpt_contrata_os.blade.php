
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-bar-chart" aria-hidden="true"></i> Reporte por Orden de Servicio
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
   <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
   <li>Reporte</li>
   <li class="active">Orden de Servicio</li>
 </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <div class="form-inline">
            <form class="form-inline" id="usr_date" method="POST" action="#">
              <div class="form-group">
                {!! Form::label('order_service', 'Orden de servicio') !!}
                <select name="order_service" id="order_service" class="form-control select2" data-live-search="true" data-size="5" style="width: 200px">
                  <option value=0>Seleccione...</option>
                  @foreach($ordens as $orden)
                    <option value="{{ $orden->id }}">{{ $orden->service_order }}</option>
                  @endforeach
                </select>
                {{-- {!! Form::select('order_service', $orden, null, ['class' => 'form-control select2','id' => 'order_service','style'=>'width:200px','placeholder' => 'Seleccionar...']) !!} --}}
                <input type="hidden" name="id" id="id">
              </div>
            </form>
          </div> 
          <div class="box-tools pull-right clearfix">
            <form action="" method="POST">
              <input type="hidden" name="fecha1" id="fecha1">
              <input type="hidden" name="fecha2" id="fecha2">           
              <button type="submit"  id="exp_exl" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar Excel</button>
            </form>
          </div>
        </div>
        <div class="box-body table-responsive no-padding">
          <div class="col-md-12">
            <table class="table table-bordered table-hover text-center">
              <thead>
                <tr>
                  <th>DNI</th>
                  <th>APELLIDO PATERNO</th>
                  <th>APELLIDO MATERNO</th>
                  <th>NOMBRES</th>              
                  <th>CARGO</th>
                  <th>CONDICIÓN</th>
                </tr>
              </thead>
              <tbody class="tbody_os">

              </tbody>
            </table>
          </div>
        </div>           
      </div>       
    </div>
  </div>
</section> 
@endsection
