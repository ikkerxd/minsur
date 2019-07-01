@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o"></i> Registro de Participantes
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
            <small>SUBIDA DE PARTICIAPANTES POR ADJUNTO</small>
          </h3>
        </div>

        <div class="box-body table-responsive no-padding">
          @include('layouts.info')
          <div class="col-md-12">
            <table class="table text-center table table-bordered">
              <tr>
                <th>SEDE:</th><td>{{$inscription[0]->nameLocation}}</td>
                <th>FECHA:</th><td>{{$inscription[0]->startDate}}</td>
                <th>HORA:</th><td>{{$inscription[0]->time}}</td>
                <th>DURACION (hr):</th><td>{{$inscription[0]->hh}}</td>
              </tr>
              <tr>
                <th>DIRECCION : </th><td colspan="5">{{$inscription[0]->address}}</td>
                <th>FACILITADOR: </th><td>{{ $facilitador[0]->full_name }}</td>
              </tr>
            </table>
          </div>
        </div>   
        <div class="box-footer">
          <h4>RUC</h4>
          <form method="post" action="{{url('val-company')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="excel">
            <br><br>
            <input type="submit" value="Enviar">
            <hr>
          </form>


          <h4>CLIENTE</h4>
          <form method="post" action="{{url('val-participant')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="excel">
            <br><br>
            <input type="submit" value="Enviar"><hr>
          </form>

          <h4>INSCRIPCION</h4>
          <form method="post" action="{{ route('register_upload_participants') }}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="excel">
            <input type="hidden" name="id_inscription" value="{{ Request::segment(2) }}">
            <br><br>
            <input type="submit" value="Enviar"><hr>
          </form>
        </div>  
      </form>    
    </div>       
  </div>
</div>
</section> 
@endsection
