
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    Registro Manual
    <small>Curso Seleccionado</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Inscripción</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-body table-responsive no-padding">
            
          {{Form::open(array('route' => 'register_part_manual_post', 'files' => true,'id' => 'form_register_inscriptions'))}}

          <div class="box-body">
            @include('layouts.info')  
           <div class="col-md-3">
            <label>SOLICITANTE</label>
             <select class="form-control select2" name="solicitante" id="">
               @foreach ($solicitantes as$solicitante)
                 <option value="{{ $solicitante->id }}">{{ $solicitante->name }} {{ $solicitante->firstlastname }} {{ $solicitante->secondlastname }}</option>
               @endforeach
             </select>
           </div>
           <div class="col-md-3">
            <label>PARTICIPANTE</label>
             <select class="form-control select2" name="participante" id="">
                @foreach ($participantes as $participante)
                 <option value="{{ $participante->id }}">{{ $participante->name }} {{ $participante->firstlastname }} {{ $participante->secondlastname }}</option>
               @endforeach
             </select>
           </div>
           <div class="col-md-3">
            <label>VOUCHER</label>
             <input type="file" name="voucher" id="voucher">  
           </div>
           <div class="col-md-1"><br>
            <input type="hidden" name="id" value="{{ Request::segment(2) }}">
             <button class="form-control">Enviar</button>
           </div>
          </div>
        </div>
      
        {{ Form::close() }}               
      </div>               
    </div>
  </section> 
  @endsection

  @section('script')

  <script type="text/javascript">
    $('#form_register_inscriptions').submit(function(){
      $('.btn_submit_register').prop('disabled',true);
      $('.btn_submit_register').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
    });
  </script>
  @endsection

