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

                </div>
              </div>
            </div>
          </div>   
      <hr>

            <h3>Lista de particpantes inscritos</h3>
      <form method="post" id="form_resh_del">
      {{ csrf_field() }}
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>
              <th><input type="checkbox" name="selectall" id="selectall"></th>
              <th>CONDICIÓN</th>                         
              <th>DNI</th>              
              <th>APELLIDO PATERNO</th>
              <th>APELLIDO MATERNO</th>
              <th>NOMBRES</th>
              <th>CARGO</th>

              {{-- <th>EDITAR</th> --}}
            </tr>
          </thead>
          <tbody>
           @foreach ($participants as $participant)
             <tr>
                 @if ($participant->state == 0)
                    <td>
                      <input type="checkbox" name="ids[]" class="selectbox" value="{{ $participant->id_user_inscription }}">
                    </td>
                     <td>
                          <span class="label label-primary">Normal</span>
                     </td>
                 @elseif($participant->state == 1)
                     <td>
                         <input type="checkbox" name="ids[]" class="selectbox" value="{{ $participant->id_user_inscription }}">
                     </td>
                     <td>
                         <span class="label label-info">Reprogramado</span>
                     </td>
                  @else
                     <td>
                         <input disabled type="checkbox" name="ids[]" class="selectbox" value="{{ $participant->id_user_inscription }}">
                     </td>
                     <td>
                         <span class="label label-danger">Anulado</span>
                     </td>
                 @endif
               <td>{{ $participant->dni }}</td>
               <td>{{ $participant->firstlastname }}</td>
               <td>{{ $participant->secondlastname }}</td>
               <td>{{ $participant->name }}</td>
               <td>{{ $participant->position }}</td>
               <td>{{ $participant->subcontrata }}</td>
               {{-- <td><a href="#">Editar</a></td> --}}
             </tr>
           @endforeach
          </tbody>
          <tfoot id="table_action_foot">
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <input type="hidden" name="id_inscription" value="{{ Request::segment(2) }}">
              <th>
                <button id="btn-reprogramar" class="btn btn-success disabled" type="submit" DISABLED
                formaction="{{ route('reschedule_user', $inscriptions[0]->id) }}">Repogramar
                </button>
              </th>
              <th>
                <button id="btn-anular" class="btn btn-danger disabled" type="submit" DISABLED
                formaction="{{ route('delete-inscription', $inscriptions[0]->id) }}">Anular
              </button>
              </th>
            </tr>
          </tfoot>               
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
      $('#selectall').click(function() {
          $('.selectbox').prop('checked', $(this).prop('checked'));
      })
      $('.selectbox').change(function() {
          var total = $('.selectbox').length;
          var number = $('.selectbox:checked').length;
          if (total === number) {
              $('#selectall').prop('checked', true);
          } else {
              $('#selectall').prop('checked', false);
          }
          if (number > 0) {
              $('#btn-anular').removeClass('disabled');
              $('#btn-reprogramar').removeClass('disabled');
              $('#btn-anular').prop('disabled',false);
              $('#btn-reprogramar').prop('disabled',false);
          } else {
              $('#btn-anular').addClass('disabled');
              $('#btn-reprogramar').addClass('disabled');
              $('#btn-anular').prop('disabled',true);
              $('#btn-reprogramar').prop('disabled',true);
          }
      })
   });
  $('#form_resh_del').submit(function(){
      $('#btn-reprogramar').prop('disabled',true);
      $('#btn-reprogramar').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
      $('#btn-anular').prop('disabled',true);
      $('#btn-anular').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
    });
  
  </script>
@endsection





