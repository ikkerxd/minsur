
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-list-ul"></i> Detalle Inscripción
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Detalle Inscripcion</li>
  </ol>  
</section>

<section class="content">
  <div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-header with-border text-center">
        <h3 class="box-title" style="text-transform: uppercase;">{{$inscription[0]->nameCourse}}<br> <small>DETALLE DE CANTIDAD DE PARTICIPANTES INSCRITAS POR CONTRATA Y VISUALIZACION DE VOUCHER</small></h3>
              <br>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>          
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <table class="table text-center table table-bordered">
                <tr>
                    
                  <th>FECHA:</th><td>{{$inscription[0]->startDate}}</td>
                  <th>SEDE:</th><td>{{$inscription[0]->nameLocation}}</td>
                  <th>DIRECCIÓN: </th><td>{{$inscription[0]->address}}</td>
                </tr>
              </table>
            </div>
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <th>#</th>
                  <th>RUC</th>
                  <th>NOMBRE DE LA CONTRATA</th>
                  <th>CANTIDAD DE PARTICIPANTE INSCRITO</th>
                  <th>VOUCHER</th>
                  <th>DESCARGAR</th>
                </thead>
                <tbody>

                  @foreach ($detail_inscriptions as $detail_inscription)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $detail_inscription->ruc }}</td>
                      <td>{{ $detail_inscription->businessName }}</td>
                      
                      <th><a href="#">{{ $detail_inscription->voucher }}</a></th>
                      <td><a href="{{ route('download_file', $detail_inscription->voucher_hash) }}" ><i class="fa fa-download" aria-hidden="true"></i></a></td>              
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>                 
          </div>                 
        </div>
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-3 col-xs-6">                                
            </div>               
          </div>            
        </div>
      </div> 
    </div>
  </div>
</section>
@endsection
