@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-book"></i> Cursos
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#">Configuracion</a></li>
    <li class="active">Cursos</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Curso</h3>
        </div> 
        {!! Form::model($course, ['route' => ['courses.update', $course->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        @include('courses.partials.form')
        {!! Form::close() !!}
      </div>         
    </div>
  </div>
</section> 
@endsection
