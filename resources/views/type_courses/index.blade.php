
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-bookmark-o" aria-hidden="true"></i> Tipo Curso
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#">Configuracion</a></li>
    <li class="active">Tipo Curso</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header">          
          <div class="input-group input-group-sm">
            <a href="{{route('type_courses.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR TIPO CURSO</a>                 
          </div>          
        </div>         
        <br>
        <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped">
          <thead>
            <tr>                            
              <th>TIPO CURSO</th>              
              <th>ESTADO</th>
              <th colspan="3">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($type_courses as $type_course)
           <tr>                            
            <td>{{ $type_course->name }}</td>           
            <td>{{ $type_course->state }}</td>
            @can('companies.show')
            <td width="10px"><a href="{{ route('type_courses.show', $type_course->id) }}" class="btn btn-sm btn-default">Ver</a></td>
            @endcan
            @can('type_courses.edit')
            <td width="10px"><a href="{{ route('type_courses.edit', $type_course->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            @endcan
            @can('type_courses.destroy')
            <td width="10px">                          

              {!! Form::open(['route' => ['type_courses.destroy', $type_course->id], 'method' => 'DELETE']) !!}
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
