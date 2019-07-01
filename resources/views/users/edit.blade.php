@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-user-o"></i> Usuarios
    <small>Gestión de usuarios</small>
</h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#">Configuracion</a></li>
    <li class="active">Usuarios</li>
</ol>
</section>

<section class="content">  
<div class="row">
    <div class="col-md-6">          
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Usuario</h3>
        </div> 
        {!! Form::model($user, ['route' => ['participants.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
           @include('users.partials.form')
           {!! Form::close() !!}
      </div>         
    </div>
  </div>
</section> 
@endsection
