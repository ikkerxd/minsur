
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
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <div class="col-md-9">
                <h3 class="box-title">Registar Participante</h3>
              </div>
                    @if(true)
                    <div class="col-md-3">
                        <a href="#" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"> Formato</i></a>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-upload"></i> Cargar
                        </button>
                    </div>
                @endif
            </div>
            {!! Form::open(['route' => 'user_store', 'class' => 'form-horizontal','files' => true,'id' => 'form_create_participant']) !!}
                @include('participants.partials.form')
            {!! Form::close() !!}
          </div>         
        </div>
      </div>
    </section>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Subir participantes desde excel</h4>
          </div>
          <form action="{{ route('upload_participant_validate') }}" enctype="multipart/form-data" method="post" >
            <div class="modal-body">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="file_up">Archivo</label>
                <input id="file_up" name="file_up" type="file" accept=".xlsx">
                <p class="help-block">Subir archivos con formato .xlsx</p>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn bg-light-blue btn-sm">Cargar</button>
            </div>

          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
  @section('script')

  <script type="text/javascript">
    $('#form_create_participant').submit(function(){
      $('.btn_submit_register').prop('disabled',true);
      $('.btn_submit_register').html('<p><i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only"></span> Registrando...</p>');
    });
  </script>
  @endsection