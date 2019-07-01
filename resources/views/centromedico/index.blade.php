
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o"></i> Programación Cursos
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Inscripción</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
         <div class="input-group input-group-sm">
          @can('inscriptions.create')
          <a href="{{route('createInscription')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> NUEVA PROGRAMACIÓN</a>
          @endcan            
        </div>           
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-hover text-center" id="tb_prom_cur">
              <thead>
                <tr>     
                  <th>ID</th>                       
                  <th>LUGAR</th>
                  <th>CURSO</th>
                  <th>HORA</th>
                  <th>INICIO</th>                  
                  <th></th>
                </tr>
              </thead>
              <tbody>
               @foreach ($inscriptions as $inscription)
               <tr> 
                 <td>{{ $inscription->id }}</td>      
                 <td>{{ $inscription->nameLocation }}</td>
                 <td>{{ $inscription->nameCourse }}</td>
                 <td>{{ $inscription->time }}</td>
                 <td>{{ $inscription->startDate }}</td>                   
                 <td>
                  <div class="btn-group">
                    <a href="{{ route('register_cm', $inscription->id) }}" class="btn btn-info"><i class="fa fa-list-ul" aria-hidden="true"></i> Consolidado</a>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">                                  
                      <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a></li>   
                      <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registrar Notas</a></li>                   
                    </ul>
                  </div>
                </td>       
              </tr>
              @endforeach  
            </tbody>      
          </table>  
        </div>                 
      </div>                 
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-3 col-xs-6">                                
        </div>               
      </div>            
    </div>
  </div> 
</div>
</div>
</section>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {
    $('#tb_prom_cur').DataTable({
      "stateSave": true,
      "processing": true,
    });
});
</script>
@endsection