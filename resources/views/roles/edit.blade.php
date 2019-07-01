@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-users" aria-hidden="true"></i> Roles
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Roles</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-md-6">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Role</h3>
            </div>           
            {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
                @include('roles.partials.form')
            {!! Form::close() !!}
          </div>         
        </div>
      </div>
    </section> 
@endsection
