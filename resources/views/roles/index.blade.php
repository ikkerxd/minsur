@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-users" aria-hidden="true"></i> Roles                    
        <small>Lista de Usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Usuarios</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header"> 
              @can('roles.create')
                    <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">REGISTRAR ROLES</a>
                    @endcan
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                        <tr>
                            <th width="10px">ID</th>
                            <th>Nombre</th>
                            <th colspan="3">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            @can('roles.show')
                            <td width="10px"><a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                            @endcan
                            @can('roles.edit')
                            <td width="10px"><a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                            @endcan
                            @can('roles.destroy')
                            <td width="10px">
                                {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'DELETE']) !!}
                                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                </button>
                                {!! Form::close()!!}
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>              
              </table>
              {{$roles->render()}}
            </div>           
          </div>       
        </div>
      </div>
    </section> 
@endsection
