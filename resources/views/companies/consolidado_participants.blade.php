
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-building-o" aria-hidden="true"></i> Reporte Pagos
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
        <br>
        <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped" id="datatable">
          <thead>
            <tr>        
              <th>#</th>               
              <th>AP.PATERNO</th>
              <th>AP.MATERNO</th>
              <th>NOMBRES</th>
              <th>DNI</th>
              <th>EMPRESA</th>
              <th>FECHA CURSO</th>
              <th>NOMBRE CURSO</th>
              <th>PRECIO</th>
              <th>SEDE</th>
              <th>PAGO</th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($invoices as $invoice)           
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $invoice->firstlastname }}</td>
              <td>{{ $invoice->secondlastname }}</td>
              <td>{{ $invoice->name }}</td>
              <td>{{ $invoice->dni }}</td>
              <td>{{ $invoice->businessName }}</td>
              <td>{{ $invoice->fecIni }}</td>
              <td>{{ $invoice->courseName }}</td>
              <td>
                {{ $invoice->price }}
              
              </td>
              <td>{{ $invoice->sede }}</td>
              <td><?php 
              if($invoice->payment_condition == 0){
                echo "Contado";
              }else{echo "Credito";}
              ?></td>
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
<script>
 $(document).ready(function() {
  $('#datatable').DataTable({
    "stateSave": true,
    "processing": true,
  });

});
</script>
@endsection