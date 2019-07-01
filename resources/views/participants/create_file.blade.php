
@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-users" aria-hidden="true"></i> Participantes
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Participantes</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-info">
            <div class="box-header with-border">
              <div class="col-md-9">
                <h3 class="box-title">Registar Participante desde excel</h3>
              </div>
            </div>

            <form action="{{ route('upload_participant_validate') }}" enctype="multipart/form-data" method="post">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="file_up">Archivo</label>
                  <input id="file_up" name="file_up" type="file" accept=".xlsx">
                  <p class="help-block">subir archivos con formato .xlsx</p>
                </div>
              </div>

              <div class="box-footer">
                <button class="btn bg-light-blue">Guardar</button>
              </div>

            </form>


          </div>         
        </div>
      </div>
    </section> 
@endsection
  @section('script')

  <script type="text/javascript">
    $('#form_create_participant').submit(function(){
      $('.btn_submit_register').prop('disabled',true);
      $('.btn_submit_register').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
    });
  </script>
  @endsection