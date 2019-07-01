
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

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header">          
          <div class="input-group input-group-sm">
            <a href="{{route('locations.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR LUGAR</a>                 
          </div>          
        </div>         
        <br>
        <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped">
          <thead>
            <tr>                            
              <th>LUGAR</th>              
              <th>ESTADO</th>
              <th colspan="3">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($locations as $location)
           <tr>                            
            <td>{{ $location->name }}</td>           
            <td>{{ $location->state }}</td>
            @can('locations.show')
            <td width="10px"><a href="{{ route('locations.show', $location->id) }}" class="btn btn-sm btn-default">Ver</a></td>
            @endcan
            @can('locations.edit')
            <td width="10px"><a href="{{ route('locations.edit', $location->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            @endcan
            @can('locations.destroy')
            <td width="10px">
              {!! Form::open(['route' => ['locations.destroy', $location->id], 'method' => 'DELETE']) !!}
              <button class="btn btn-sm btn-danger btn-delete">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
              </button>
              {!! Form::close()!!}                              
            </td>
            @endcan
          </tr>
          @endforeach  
        </tbody>              
      </table>      
    </div>           
  </div>       
</div>
</div>
</section> 
@endsection
