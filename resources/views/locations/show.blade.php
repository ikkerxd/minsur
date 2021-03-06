@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-map-marker"></i> Lugar
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Lugar</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><strong>{{$location->name}}</strong></h3>
            </div>
            
            <div class="box-body table-responsive no-padding">
                    <div class="container">                       
                        <a class="btn btn-default" href="{{ route('locations.index')}}">Regresar</a>
                        <br><br>
                    </div>
            </div>           
          </div>       
        </div>
      </div>
    </section> 
@endsection