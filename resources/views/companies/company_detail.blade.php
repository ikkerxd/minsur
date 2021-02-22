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
                        <h4> Detalle de pagos de empresas </h4>
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
                                <th>COD VALORIZACION</th>
                                <th>N° FACTURAL</th>
                                <th>PERIODO</th>
                                <th>AÑO</th>
                                <th>MONTO</th>
                                <th>HORAS</th>
                                <th>FECHA DE PAGO</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

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