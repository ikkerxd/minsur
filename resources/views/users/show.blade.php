@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-user-o"></i> Usuarios
        <small>Lista de Usuarios</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Usuarios</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lista de Usuarios</h3>
            </div>
            
            <div class="box-body table-responsive no-padding">
                    <div class="container">
                        <p><strong>Nombre</strong> {{$user->name}}</p>
                        <p><strong>Email</strong> {{$user->email}}</p>
                        <a class="btn btn-default" href="{{ route('users.index')}}">Regresar</a>
                        <br><br>
                    </div>
            </div>           
          </div>       
        </div>
      </div>
    </section> 
@endsection