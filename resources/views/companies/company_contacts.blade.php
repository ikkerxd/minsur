@extends('layouts.templates')

@section('content')
<section class="content-header">
    <h1>
        <i class="fa fa-building-o" aria-hidden="true"></i> Empresas
        <small>Version 1.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Empresas</li>
    </ol>
</section>

<!-- Main content -->

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <div class="row">
                    <div class="col-md-8">
                        <h4> Relación de contactos de emrpesa contratistas </h4>
                            <div class="form-group">
                                <button type="submit" name="action" value="read" class="btn bg-primary" style=" position: relative;top: 21.5px;"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar datos</button>
                            </div>
                        </div>
                </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    @include('layouts.info')
                    <br>
                    <table class="table table-bordered table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>RUC</th>
                                <th>RAZON SOCIAL</th>
                                <th>TELEFONO</th>
                                <th>CORREO</th>
                                <th>CORREO VALORIZACION</th>
                                <th>UNIDAD MINERA</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($companies1 as $company)
                            <tr>
                                <td>{{ $company->id_user }}</td>
                                <td>{{ $company->ruc }}</td>
                                <td>{{ $company->businessName }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ $company->email}}</td>
                                <td>{{ $company->email_valorization }}</td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    @if ($company->estadous == 0)
                                        <span class="label label-success"> Activo </span>
                                    @else
                                        <span class="label label-danger"> Bloqueado </span>
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)
                                    <button type="button" class="btn btn-primary btn-sm btn-val" data-toggle="modal" data-target="#myModalPagar" rel="tooltip" data-placement="top" title="Monto a Pagar">
                                    Editar
                                    <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Start Modal editar contacto-->
<div class="modal fade" id="myModalPagar"  tabindex="-1" role="dialog" aria-labelledby="ModalFac">
    <div class="modal-dialog" >
      <div class="modal-content" role="document">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4 class="modal-title" id="myModalLabel">Actualizar datos del contacto de la empresa: <span class="nameConpamy"></span></h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Usuario:</label>
                        <div class="col-sm-10">
                          <input type="email" disabled class="form-control" id="email"  value=""placeholder="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="#" class="col-sm-3 col-form-label">Empresa:</label>
                        <div class="col-sm-10">
                          <input type="text" disabled class="form-control" id="#"  value=""placeholder="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="#" class="col-sm-3 col-form-label">Estado usuario:</label>
                        <select class="custom-select custom-select-lg mb-3" >
                            <option value="0">Activo</option>
                            <option value="1">Bloqueado</option>
                        </select>
                </div>
            </div>   
          
        </div>
        <div class="modal-footer" style="text-align: center">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close" aria-hidden="true"></i>
            Cancelar</button>
          <button type="button" class="btn btn-success" data-dismiss="modal"> <i class="fa fa-money" aria-hidden="true"></i> Actualizar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal editar contacto -->
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatable').DataTable({
            "stateSave": true,
            "processing": true,
        });
    });
</script>
@endsection('content')