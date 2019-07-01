@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-list-ul"></i> Repogramación Inscripción
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
      <div class="box box-success">
        <div class="box-header with-border">
          <a class="btn btn-primary pull-right" onClick="window.print();return false" href="#" role="button"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</a>      
        </div>
        
        <div class="box-body">
          <div class="row">
            <div class="container-fluid">
              <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-7">    
                      <label ><i class="fa fa-book" aria-hidden="true"></i> CURSO Y FECHA</label> 
                      <p>{{$inscriptions[0]->nameCurso}} {{ \Carbon\Carbon::parse($inscriptions[0]->startDate)->format('d/m')}}</p>
                    </div>

                    <div class="col-md-5">
                     <label><i class="fa fa-clock-o" aria-hidden="true"></i> HORA INICIO</label>
                     <p class="form-control-static">{{$inscriptions[0]->time}}</p> 
                   </div>
                 </div>
                <br>  
                <div class="row">
                  <div class="col-md-7">
                    <label><i class="fa fa-location-arrow" aria-hidden="true"></i> DIRECCION:</label>
                    <p class="form-control-static">{{$inscriptions[0]->address}}</p>   
                  </div>

                  <div class="col-md-5">
                   <label><i class="fa fa-map-marker" aria-hidden="true"></i> LUGAR</label>           
                   <p class="form-control-static">{{$inscriptions[0]->nameLocation}}</p> 
                 </div>
                </div>
              </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="text-green">
                      LISTA DE PRTICIPNTES A REPROGRAMAR
                    </label>              
                    @foreach ($participants as $participant)                      
                       <p>{{ $participant->dni }}-{{ $participant->firstlastname }} {{ $participant->secondlastname }} {{ $participant->name }}
                       </p>
                   @endforeach

                </div>
              </div>
            </div>
          </div>   
      <hr>
      <form method="post">
      {{ csrf_field() }}
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>
              <th>Lugar/sede</th>                         
              <th>Curso</th>              
              <th>Fecha</th>
              <th>Horario</th>
              <th>Tiempo de Curso</th>
              <th>Vacantes</th>
              <th>Acciones</th>              
              {{-- <th>EDITAR</th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
             <tr>
               <td>{{ $course->nameLocation }}</td>
               <td>{{ $course->nameCurso }}</td>
               <td>{{ $course->startDate }}</td>
               <td>{{ $course->time }}</td>
               <td>{{ $course->hours }} hr.</td>
               <td>{{ $course->slot }}</td>

               <td>
                  <form method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_inscription" value="{{ Request::segment(2) }}">
                    <input type="hidden" name="id_new_inscription" value="{{ $course->id }}">
                    @foreach ($participants as $participant)                      
                      <input type="hidden" name="participants[]" value="{{ $participant->idUI }}">
                    @endforeach
                    <button id="btn-repro" class="btn btn-primary" type="submit" 
                    formaction="{{ route('reschedule-validate', $inscriptions[0]->id) }}">
                      <i class="fa fa-chevron-circle-right"></i> Reprogramar</button>
                  </form>
               </td>
               
             </tr>
           @endforeach
           {{-- @foreach ($participants as $participant)
             <tr>
                <td>{{ $participant->dni }}</td>
                <td>{{ $participant->firstlastname }}</td>
                <td>{{ $participant->secondlastname }}</td>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->position }}</td>
                <td>{{ $participant->subcontrata }}</td>             
             </tr>
           @endforeach --}}
          </tbody>
        </table> 

      </form>
      </div>          

      </div>
    </div>
  </div>
</section>

@endsection

@section('script')
<script>
  $( document ).ready(function() {   

    $('.textarea').wysihtml5();

   });
  </script>
@endsection