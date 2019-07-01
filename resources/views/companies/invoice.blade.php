
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
              <th>ID</th> 
              <th>SEDE</th>
              <th>RUC</th>
              <th>RAZON SOCIAL</th>
              <th>CURSO</th>
              <th>FECHA</th>
              <th>CONDICION</th>
              <th>VOUCHER</th>
              
            </tr>
          </thead>
          <tbody>
            @foreach($invoices as $invoice)
            @if($invoice->voucher !== null)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <th>{{ $invoice->id_user_inscription }}</th>
              <td>{{ $invoice->nameLocation }}</td>
              <td>{{ $invoice->ruc }}</td>
              <td>{{ $invoice->businessName }}</td>
              <td>{{ $invoice->courseName }}</td>
              <td>{{ $invoice->startDate }}</td>
              <td><?php 
              if($invoice->payment_condition == 0){
                echo "Contado";
              }else{echo "Credito";}
              ?></td>
              <td><a href="{{ route('download_file', $invoice->voucher_hash) }}">{{ $invoice->voucher }}</a></td>
            </tr>
            @endif
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