@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-refresh" aria-hidden="true"></i> Reprogramar
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Detalle Inscripción</a></li>
    <li class="active">Reprogramación</li>
  </ol>
</section>

{{-- <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header"> 
       <h3 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>INFORMACIÓN</strong></h3>                     
     </div> 
     <div class="box-body">
      <div class="alert alert-info" role="alert">
        <strong>SELECCIONAR</strong><br>
        Los participantes pueden ser reprogramados con 48 horas de anticipación, pasado el tiempo establecido la opción de reprogramar se ocultará para no generar inconvientes a la inscripción.
      </div>  
      <div class="alert alert-warning" role="alert">
        <strong>LIMITE DE TIEMPO</strong><br>
        Los participantes pueden ser reprogramados con 48 horas de anticipación, pasado el tiempo establecido la opción de reprogramar se ocultará para no generar inconvientes a la inscripción.
      </div>      
    </div>
  </div>
</div> --}}

<input type="hidden" id="opt" value="1">
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title text-danger">1) LISTA DE PARTICIPANTES</h3>          
        </div>
        <div class="box-body">
          {!! Form::open(['route' => 'reschedule_start', 'id' => 'reschedule_start']) !!}
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover text-center">
                    <thead>                                            
                      <tr>
                        <th>DNI</th>              
                        <th>APELLIDO PATERNO</th>
                        <th>APELLIDO MATERNO</th>
                        <th>NOMBRES</th>
                        <th>CARGO</th>
                        <th>RAZON SOCIAL</th>              
                        <th>SELECCIONAR</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($participants as $participant)
                      <tr>
                        <td>{{$participant->dni}}</td>
                        <td>{{$participant->firstLastName}}</td>
                        <td>{{$participant->secondLastName}}</td>
                        <td>{{$participant->name}}</td>
                        <td>{{$participant->position}}</td>
                        <td>{{$participant->company}}</td>
                        <td>{!! Form::checkbox('chk_reschedule[]', $participant->id) !!}</td>
                      </tr>          
                      @endforeach
                    </tbody>              
                  </table> 
                </div>
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

  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title  text-danger">2) LISTA DE CURSOS DISPONIBLES</h3>
            <div class="box-tools pull-right clearfix">
              <div class="form-inline">
                <div class="form-group">
                  <label><i class="fa fa-map-marker" aria-hidden="true"></i> LUGAR</label>
                  <select name="locations" id="locations" class="form-control locations" style="background: #FFFFE0;font-weight: bold;">
                    @foreach ($locations as $location)
                    <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label><i class="fa fa-book" aria-hidden="true"></i> TIPO CURSO</label>
                  <select name="type_courses" id="type_courses" class="form-control type_courses" style="background: #FFFFE0;font-weight: bold;">
                    @foreach ($type_courses as $type_course)
                    <option value="{{$type_course->id}}">{{$type_course->name}}</option>
                    @endforeach
                  </select>
                </div>           
              </div> 
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">              
                <div class="table-responsive">
                  <table id="table_reschedule" class="table table-bordered table-hover text-center">
                    <thead>                                          
                      <tr>                            
                        <th>LUGAR</th>
                        <th>CURSO</th>
                        <th>FECHA INICIO</th>              
                        <th>VACANTES</th>              
                        <th colspan="3">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody class="body">           
                    </tbody>              
                  </table>
                </div>
              </div>                 
            </div>                 
          </div>
          <div class="box-footer">
            <div class="row pull-right">          
              <div class="col-md-12">
                <input type="hidden" name="id_inscription" class="id_inscription">
                <input type="hidden" name="id_user_inscription_old" value="{{$id_user_inscription}}">
                <a href="#" class="btn btn-link">Cancelar</a> 
                <button class="btn btn-primary" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i> Reprogramar</button>
              </div>               
            </div>            
          </div>
        {{ Form::close() }}
      </div> 
    </div>
  </div>
</section>
@endsection