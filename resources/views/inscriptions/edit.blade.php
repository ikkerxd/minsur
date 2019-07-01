@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o"></i> Apertura Curso
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="#">Configuracion</a></li>
    <li class="active">Inscripción</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-8">          
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Editar Inscripción</h3>
        </div> 
        {!! Form::model($inscription, ['route' => ['inscriptions.update', $inscription->id], 'method' => 'PUT']) !!}
        @include('inscriptions.partials.form')
        {!! Form::close() !!}
      </div>         
    </div>
  </div>
</section> 

@endsection


@section('script')
<script>
  $( document ).ready(function() {
   $('.datepicker').datepicker({
     format: 'yyyy-mm-dd'      
   });


   $('.timepicker').timepicker({
     showInputs: false,
     defaultTime: '08:00 AM'
   });

   $('.textarea').wysihtml5();
 });
  
</script>
@endsection
