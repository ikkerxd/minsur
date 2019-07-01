@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-pencil-square-o"></i> Registro Notas y Asistencia
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Inscripción</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
            <h3 class="box-title" style="text-transform: uppercase;">{{$inscription[0]->nameCourse}}
              <br>
                <small>CONSOLIDADO DE PARTICIPANTES INSCRITOS</small>
              </h3>
            </div>
            
            <div class="box-body table-responsive no-padding">
              @include('layouts.info')
              <div class="col-md-12">
                <table class="table text-center table table-bordered">
                <tr>
                  <th>SEDE:</th><td></td>
                  <th>FECHA:</th><td></td>
                  <th>HORA:</th><td></td>
                  <th>DURACION (hr):</th><td></td>
                </tr>
                <tr>
                  <th>DIRECCION : </th><td colspan="5"></td>
                  <th>FACILITADOR: </th><td></td>
                </tr>
              </table>
              </div>
              <br>
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>DNI</th>
                    <th>AP.PATERNO</th>
                    <th>AP.MATERNO</th>
                    <th>NOMBRES</th>
                    <th>EMPRESA</th>
                    <th>ASISTENCIA</th>
                    <th>NOTA</th>
                  </tr>
                </thead>
                <form method="post" action="{{ route('update_point') }}">
                {!! csrf_field() !!}
                <tbody>
                  
                </tbody>
                
              </table>

            </div>   
             <div class="box-footer">
          <div class="row">
            <div class="col-md-12">
            <input type="hidden" name="id_inscription" value="{{ Request::segment(2) }}"> 
            <button class="btn btn-success pull-right">Registrar</button>                        
            </div>               
          </div>            
        </div>  
        </form>    
          </div>       
        </div>
      </div>
    </section> 
@endsection
