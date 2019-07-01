
@extends('layouts.templates')

@section('style')
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
@endsection
@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-check" aria-hidden="true"></i>  {{$inscriptions[0]->nameCourse}}
    <small>Curso Seleccionado</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Inscripción</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body table-responsive no-padding">
            
          {{Form::open(array('route' => 'userInscriptions.store', 'files' => true,'id' => 'form_register_inscriptions'))}}

          <div class="box-body">
            @include('layouts.info')  
            <div class="col-md-12">
              <label class=""><i class="fa fa-list" aria-hidden="true"></i> DATOS GENERALES :</label>
              <br>
              <table class="table table-striped table-bordered">
                <tr>
                  <th>SEDE:</th><td>{{$inscriptions[0]->nameLocation}}</td>
                  <th>FECHA:</th><td>{{$inscriptions[0]->startDate}}</td>
                </tr>
                <tr>
                  <th>HORA:</th><td>{{$inscriptions[0]->time}}</td>
                  <th>DURACIÓN:</th><td>{{$inscriptions[0]->hh}} hrs</td>
                </tr>

              </table>

            </div>

            <div class="col-md-12">
              <h4>Tiene <span class="label bg-aqua">{{ $count_part }}</span> participantes registrado en este curso.</h4>
              <br>
            </div>
            <div class="col-md-12">
               <div class="form-group{{ $errors->has('chk_participant') ? ' has-error' : '' }}">                           
                <table class="table text-center" id="example1">
                <thead>
                 <tr>
                   <th>Seleccionar</th>
                   <th>DNI</th>
                   <th>Participante</th>
                   <th>Area</th>
                 </tr>
               </thead>
               <tbody>
                @foreach ($participants as $participant)
                <tr>
                 <td>{!! Form::checkbox('chk_participant[]', $participant->id) !!}</td> 
                  <td>{{ $participant->dni }}</td>
                  <td>{{ $participant->firstlastname." ".$participant->secondlastname." ".$participant->name }}</td>
                  <td>{{ $participant->superintendence }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>

                @if ($errors->has('chk_participant'))
                <span class="help-block">
                  <strong>{{ $errors->first('chk_participant') }}</strong>                    
                </span>
                @endif               
              </div>
          </div>
        </div>
        <div class="box-footer">
          <input type="hidden" name="id_inscription" value="{{ $id }}">
          <input type="hidden" name="id_user" value="{{ $idUser }}">
          <input type="hidden" name="businessName" value="{{ $businessName }}">
          <input type="hidden" name="slot" class="slot" value="{{$inscriptions[0]->slot}}">
          <input type="hidden" name="idLocation"  value="{{$inscriptions[0]->idLocaltion}}">
          <button type="submit" class="btn btn-primary btn-sm btn_submit_register pull-right"><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Registrar</button>
          <a href="{{url('/inscription')}}">Cancelar</a>
        </div>
        {{ Form::close() }}               
      </div>               
    </div>
  </section> 
  @endsection

  @section('script')

  <script type="text/javascript">
    $('#form_register_inscriptions').submit(function(){
      $('.btn_submit_register').prop('disabled',true);
      $('.btn_submit_register').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
    });
  </script>
  @endsection

