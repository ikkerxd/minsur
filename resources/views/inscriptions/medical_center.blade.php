
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-user-md" aria-hidden="true"></i>Programación Médica
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Inscripción</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
         {{--  <h3 class="box-title">Filtro de participante por documento de identidad</h3> --}}
          </div>
          <div class="box-body">
          <div class="row">
            <div class="col-md-4">              
              <form id="search_user_validate2" class="form-inline">
              {{ csrf_field() }}
                <div class="form-group">                  
                  <input type="text" class="form-control text-center" name="dni_ce" id="dni_ce" placeholder="Ingrese Doc Identidad">
                </div>
                <button type="submit" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
              </form>     
          </div>
          <div class="col-md-8">
            <a class="btn btn-primary pull-right" onClick="window.print();return false" href="#" role="button"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>
          </div>
        </div>
        <hr>
        <div class="row">            
          <div class="col-md-12">           
            <table class="table table-bordered table-hover text-center">
              <thead>
                <tr>     
                    <th>FEC. CURSO</th>
                    <th>DNI</th>
                    <th>PARTICIPANTE</th>
                    <th>CURSO</th>
                    <th>EMPRESA</th>
                    <th>FEC. VENCIMIENTO</th>
                    <th>DIAS RESTANTES</th>
                    <th>ESTADO</th>
                    
                </tr>
              </thead>
              <tbody class="tbody_his_dni_2">           
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
