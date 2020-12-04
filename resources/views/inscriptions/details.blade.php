
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
        <div class="box-body">
          <table class="table table-bordered table-hover text-center">
            <thead>
              <tr>
                <th>LUGAR/SEDE</th>
                <th>MODALIDAD</th>
                <th>CURSO</th>
                <th>FECHA</th>
                <th>CONDICIÓN</th>            
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($inscriptions as $inscription)
              <tr>
                <td>{{$inscription->name}}</td>
                @if($inscription->modality == "O")
                  <td>ONLINE</td>
                @else
                  <td>PRESENCIAL</td>
                @endif
                <td>{{$inscription->nameCurso}}</td>
                <td>{{$inscription->startDate}}</td>
                  <td>
                  @if ($inscription->state == 0)
                  <span class="label label-success">Normal</span>
                  @elseif ($inscription->state == 1)
                  <span class="label label-info">Reprogramado</span>
                  @else
                  <span class="label label-danger">Anulado</span>
                  @endif
                  </td>
                <td>
                 @if ($inscription->state != 2)
                    <a href="{{ url('detail-inscriptionc/'.$inscription->id_inscription)}}" class="btn btn-sm btn-default" ><i class="fa fa-list-ul" aria-hidden="true"></i> Detalle</a>
                  @else
                    <span class="label label-default">Anulado</span>
                 @endif
              </td>

            </tr>
            @endforeach
          </tbody>              
        </table>
      </div>
      <!-- /.box-body -->
      
    </div>
  </div>
</div>
</section>
@endsection
