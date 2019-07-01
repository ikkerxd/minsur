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
                  <th>SEDE:</th><td style=background:#fffa65>{{$inscription[0]->nameLocation}}</td>
                  <th>FECHA:</th><td style=background:#fffa65>{{$inscription[0]->startDate}}</td>
                  <th>HORA:</th><td style=background:#fffa65>{{$inscription[0]->time}}</td>
                  <th>DURACION (hr):</th><td style=background:#fffa65>{{$inscription[0]->hh}}</td>
                </tr>
                <tr>
                  <th>DIRECCION : </th><td colspan="5"  style=background:#fffa65>{{$inscription[0]->address}}</td>
                  <th>FACILITADOR: </th><td  style=background:#fffa65>{{ $facilitador[0]->full_name }}</td>
                </tr>
              </table>
              </div>
              <br>
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>DNI</th>
                    <th>AP.PATERNO</th>
                    <th>AP.MATERNO</th>
                    <th>NOMBRES</th>
                    <th>ASISTENCIA</th>
                    <th>NOTA</th>
                    <th>OBSERVACIONES (opcional)</th>
                  </tr>
                </thead>
                <form method="post" action="{{ route('update_point') }}">
                {!! csrf_field() !!}
                <tbody>
                  @foreach ($participants as $participant)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $participant->dni }}</td>
                    <td>{{ $participant->firstlastname }}</td>
                    <td>{{ $participant->secondlastname }}</td>
                    <td>{{ $participant->name }}</td>
                    <td>
                      <select name="assistence[]" class="form-control">
                        @if ($participant->assistence != "F")
                          <option value="A" checked>Asistio</option>
                          <option value="F">Falto</option>
                        @else
                          <option value="F" checked>Falto</option>
                          <option value="A">Asistio</option>
                        @endif
                      </select>
                    </td>
                    <td><input type="number" min="0" max="20" name="point[]" class="form-control" value="{{ $participant->point }}"></td>
                    <td><input type="text" name="obs[]" maxlenght="10" class="form-control" value="{{ $participant->obs }}"></td>
                  </tr>
                  <input type="hidden" name="id_user_inscription[]" value="{{ $participant->id }}">
                  @endforeach
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
