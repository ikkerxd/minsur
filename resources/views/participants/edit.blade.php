@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Participante
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Editar Participante</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">          
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Editar participante</h3>
        </div> 
        {!! Form::model($users, ['route' => ['update_participants', $users->id], 'method' => 'PUT', 'class' => 'form-horizontal','files' => true]) !!}
        @include('participants.partials.form')
        {!! Form::close() !!}
      </div>         
    </div>
  </div>
</section> 
@endsection
