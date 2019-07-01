@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-ban" aria-hidden="true"></i> Anular
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Detalle Inscripción</a></li>
    <li class="active">Anulación</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title text-danger">1) LISTA DE PARTICIPANTES</h3>          
        </div>
        <div class="box-body">
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
                  <form id="cancel_start" method="POST" action="{{route('cancel_start')}}">
                    {!! csrf_field() !!}
                    <tbody>
                      @foreach ($participants as $participant)
                      <tr>
                        <td>{{$participant->dni}}</td>
                        <td>{{$participant->firstLastName}}</td>
                        <td>{{$participant->secondLastName}}</td>
                        <td>{{$participant->name}}</td>
                        <td>{{$participant->position}}</td>
                        <td>{{$participant->company}}</td>
                        <td>{!! Form::checkbox('chk_delete[]', $participant->id) !!}</td>
                      </tr>          
                      @endforeach
                    </tbody>                        
                  </table> 
                </div>
              </div>                 
            </div>                 
          </div>
          <div class="box-footer">
           <div class="row pull-right">          
            <div class="col-md-12">              
              <input type="hidden" name="id_user_inscription_old" value="{{$id_user_inscription}}">
              <a href="#" class="btn btn-link">Cancelar</a> 
              <button class="btn btn-danger" type="submit"><i class="fa fa-ban" aria-hidden="true"></i> Anular</button>
            </div>               
          </div>            
        </div>
      </form>
    </div> 
  </div>
</div>
</section>


{{-- <section class="content">
  <div class="row">
  <div class="col-md-4">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>INFORMACIÓN</strong></h3>       
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
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
</section> --}}

@endsection