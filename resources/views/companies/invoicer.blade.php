
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
       <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped" id="datatable">
          <thead>
            <tr>        
            <th>#</th>                    
              <th>RUC</th>
              <th>RAZON SOCIAL</th>
              <th>DIRECCION</th>
              <th>ESTADO</th>
              <th></th>
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
