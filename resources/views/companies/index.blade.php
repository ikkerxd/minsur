
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
        <div class="box-header">          
          <div class="input-group input-group-sm">
            <a href="{{route('companies.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR EMPRESA</a>                 
          </div> 
       </div>         
       <br>
       <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped" id="datatable">
          <thead>
            <tr>        
                <th>#</th>
                <th>RUC</th>
                <th>RAZON SOCIAL</th>
                <th>TELEFONO</th>
                <th>CORREO</th>
                <th>CORREO VLORIZACION</th>
                <th>ESTADO</th>
                <th></th>
            </tr>
          </thead>
          <tbody>
           @foreach ($companies as $company)
           <tr>  
           <th>{{ $company->id_company }}</th>
               <td>{{ $company->ruc }}</td>
               <td>{{ $company->businessName }}</td>
               <td>{{ $company->phone }}</td>
               <td>{{ $company->email}}</td>
               <td>{{ $company->email_valorization }}</td>
            <td>
              @if ($company->state == 0)
                <span>Activo</span>
              @else
                <span>Inactivo</span>
              @endif
            </td>
             <td width="10px"><a href="{{ route('companies.show', $company->id_company) }}" class="btn btn-sm btn-warning">Ver</a></td>
            {{-- @can('companies.show')
            <td width="10px"><a href="{{ route('companies.show', $company->id) }}" class="btn btn-sm btn-default">Ver</a></td>
            @endcan
            @can('companies.edit')
            <td width="10px"><a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            @endcan
            @can('companies.destroy')
            <td width="10px">                          

              {!! Form::open(['route' => ['companies.destroy', $company->id], 'method' => 'DELETE']) !!}
              <button class="btn btn-sm btn-danger btn-delete">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
              </button>
              {!! Form::close()!!}                              
            </td>
            @endcan --}}
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
@endsection
