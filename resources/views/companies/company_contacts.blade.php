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
                                <td>
                                     @if($company->idunidad==1)
                                     
                                        <span class="label label-primary">UM Raura</span>
                                     @elseif($company->idunidad==2)
                                     <span class="label label-warning">UM SanRafael</span>

                                     @elseif($company->idunidad==3)
                                     <span class="label label-success">UM Pucamarca</span>
                                     @else
                                     <span class="label label-info">UM Fundición Pisco</span>
                                     @endif
                                </td>
                                
                                <td>
                                    <input type="checkbox"  class="togle-class" data-id="{{ $company->id_user}}" data-toggle="toggle" data-style="slow" data-on="Activo" 
                                    data-off="Bloqueado" {{$company->estadous == 0 ?'checked':''}}>
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
@push('scripts')

<script>
    $(function() {
      $('#toggle-two').bootstrapToggle({
        on: 'Enabled',
        off: 'Disabled'
      });
    })
  </script> 

  <script> 
      $('.togle-class').on('change',function() {
        var status = $(this).prop('checked')==true ? 0:1 ;
        //alert(status);
        var id_user = $(this).data('id');
        //alert(id_user); 
        $.ajax ({
            type: 'GET',
            datatype:'JSON',
            url:'{{ route('statusUpdate') }}',
            data: {
                'status':status,
                'id_user':id_user
            },
            success:function(data){
                $('#notifDiv').fadeIn();
                $('#notifDiv').css('background','green');
                $('#notifDiv').text('Actualizado');
                setTimeout(() => {
                    $('#notifDiv').fadeOut();
                });
            }
              
        });
      });
  </script>
@endpush
@endsection('content')