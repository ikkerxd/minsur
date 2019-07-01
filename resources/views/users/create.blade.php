
@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-user-o"></i> Usuario
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Usuario</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-md-12">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registar Usuario</h3>
            </div>           
            {!! Form::open(['route' => 'users.store', 'class' => 'form-horizontal', 'files' => true]) !!}
                @include('users.partials.form')
            {!! Form::close() !!}
          </div>         
        </div>
      </div>
    </section> 
@endsection
