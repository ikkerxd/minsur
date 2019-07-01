
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-user-o"></i> Usuarios
    <small>Version 1.0</small>
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
            <div class="input-group input-group-sm">
              <a href="{{route('users.create')}}" class="btn btn-success btn-sm">REGISTRAR USUARIO</a>                 
          </div>             
      </div>
      <!-- /.box-header -->
      {{-- <div class="box-body table-responsive no-padding">
        <table class="table table-hover" id="example1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th colspan="3">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>                            
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><span class="label label-success">Activo</span></td>
                    @can('users.show')
                    <td width="10px"><a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                    @endcan
                    @can('users.edit')
                    <td width="10px"><a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                    @endcan
                    @can('users.destroy')
                    <td width="10px">
                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
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
    </div>  --}}     
    <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th colspan="3"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>                            
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td><span class="label label-success">Activo</span></td>
                    @can('users.show')
                    <td width="10px"><a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                    @endcan
                    @can('users.edit')
                    
                      <td width="10px"><a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                   
                    @endcan
                    @can('users.destroy')
                    <td width="10px">
                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE']) !!}
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
            </div>     
</div>       
</div>
</div>
</section> 
@endsection

@section('script')
<script>
    $(document).ready(function() {
      
        
        /*$('#example1').DataTable({
            'paging': true,
            'info'  : true,
            'filter': true,
            'stateSave': true,
        });  */

        //$('#example1').DataTable();    
    

  //   $('#example1').DataTable({
  //   'paging': true,
  //   'info'  : true,
  //   'filter': true,
  //   'stateSave': true,

  //   'ajax':{
  //     "url": 'json_list_user',
  //     "type":"POST",
  //     dataSrc: function(data){
  //       return data;
  //     }
  //   },
  //   'columns':[
  //     {data: 'name'},
  //     {data: 'email'},      
  //     {"orderable": true,
  //     render:function(data, type, row){
  //       return '<div class="btn-group">'+
  //       '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+
  //       'Opcion <span class="caret"></span>'+
  //       '</button>'+
  //       '<ul class="dropdown-menu">'+
  //       '<li><a href='"><span class='glyphicon glyphicon-pencil' aria-hidden="true"></span> Editar</a></li>"+
  //       '<li><a href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar</a></li>'+
  //       '</ul>'+
  //       '</div>';
  //     }
  //   }
  // ],
  //   "order": [[ 3, "asc" ]],
    
  // });

    } );
</script>
@endsection

