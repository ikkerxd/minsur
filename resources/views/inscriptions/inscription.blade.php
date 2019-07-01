
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Inscripción
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

<input type="hidden" id="opt" value="0">
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success"> 
        <div class="box-header">         
         
          <div class="col-md-3">                   
            <i class="fa fa-map-marker" aria-hidden="true"></i> <label>Seleccione lugar</label>
            <select name="locations" id="locations" class="form-control locations" >
              @foreach ($locations as $location)
              <option value="{{$location->id}}">{{$location->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">              
            <i class="fa fa-book" aria-hidden="true"></i> <label for="">Seleccione un tipo de curso</label>
            <select name="type_courses" id="type_courses" class="form-control type_courses">
              @foreach ($type_courses as $type_course)
              <option value="{{$type_course->id}}">{{$type_course->name}}</option>
              @endforeach
            </select>
          </div>        
        </div>         
        
        <div class="box-body">

          <h4 class="box-title">Selecione un curso</h4>
          <table class="table table-bordered table-hover text-center">
            <thead>
              <tr>                            
                <th>LUGAR / SEDE</th>
                <th>CURSO</th>
                <th>FECHA</th>      
                <th>HORARIO</th>
                <th>HORAS DEL CURSO</th>
                <th>VACANTES</th>        
                <th></th>
              </tr>
            </thead>
            <tbody class="body">
            </tbody>              
          </table> 
        </div>          

      </div>
    </div>
  </div>
</section>
@endsection
