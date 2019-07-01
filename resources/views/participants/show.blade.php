
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-users"></i> Detalle General
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Participantes</li>
  </ol>
</section>

<section class="content">
  <div class="row">
  <div class="col-md-12">
    <div class="box">
        <div class="box-body">
          <div class="row">
            <div class="col-md-2">
               <div class="form-group">
               
              <img src="{{ asset( '/img/'.$users[0]->image_hash) }}" class="img-responsive center-block">
            </div>
            </div> 
            <div class="col-md-5">
              <table class="table table table-striped">
                <tr>
                  <th>Nombre Completo</th><td>{{ $users[0]->name }} {{ $users[0]->firstlastname }} {{ $users[0]->secondlastname }}</td>
                </tr>
                <tr>
                  <th>Doc. Identidad</th><td>{{ $users[0]->dni }}</td>
                </tr>
                <tr>
                  <th>Correo</th><td><a href="mailto:{{ $users[0]->email }}">{{ $users[0]->email }}</a></td>
                </tr>
                <tr>
                  <th>Celular</th><td>{{ $users[0]->phone }}</td>
                </tr>
                <tr>
                  <th>Fecha Nacimiento</th><td>{{ $users[0]->birth_date }}</td>
                </tr>
                <tr>
                  <th>Género</th><td>@if ($users[0]->gender == 0) Masculino @else Femenino @endif</td>
                </tr>
              </table>
            </div> 
            <div class="col-md-5">
              <table class="table table table-striped">
                <tr>
                  <th>Examen Médico</th><td>{{ $users[0]->medical_exam }}</td>
                </tr>
                <tr>
                  <th>Gerencia</th><td>{{ $users[0]->nameManagement }}</td>
                </tr>
                <tr>
                  <th>Superintendencia</th><td>{{ $users[0]->superintendence }}</td>
                </tr>
                <tr>
                  <th>Lugar Procedencia</th><td>@if ($users[0]->origin == 0) Lima @elseif($users[0]->origin == 1) Arequipa @else Cusco @endif</td>
                </tr>
                <tr>
                  <th>Codigo Bloqueo</th><td>{{ $users[0]->code_bloqueo }}</td>
                </tr>
              </table>
            </div>                 
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead>
                  <tr>
                    <th>SEDE</th>
                    <th>FECHA</th>
                    <th>CURSO</th>
                    <th>NOTA</th>
                    <th>ASISTENCIA</th>
                  </tr>
                </thead>
                <tbody>
                   @foreach ($result as $element)
                    <tr>
                      <td>{{ $element->sede }}</td>
                      <td>{{ $element->fecha }}</td>
                      <td>{{ $element->curso }}</td>
                      <td>{{ $element->nota }}</td>
                      <td>{{ $element->asistencia }}</td>
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
