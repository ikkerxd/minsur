
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
    <li><a href="#">Configuración</a></li>
    @endrole
    <li class="active">Inscripción</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)
        <div class="box-header with-border">
         <div class="input-group input-group-sm">
          @can('inscriptions.create')
          <a href="{{route('inscriptions.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> NUEVA PROGRAMACIÓN</a>
          @endcan            
        </div>
        @endif
      </div>
      <div class="box-body">
        @include('layouts.info')
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-hover text-center" id="tb_prom_cur">
              <thead>
                <tr>     
                  <th>ID</th>                       
                  <th>LUGAR</th>
                  <th>MODALIDAD</th>
                  <th>CURSO</th>
                  <th>HORA</th>
                  <th>FECHA</th>
                  <th>DIRECCION</th>
                  <th>ACCIONES</th>
                </tr>
              </thead>
              <tbody>
               @foreach ($inscriptions as $inscription)
               <tr> 
                 <td>{{ $inscription->id }}</td>      
                 <td>{{ $inscription->nameLocation }}</td>
                 @if($inscription->modality == "O")
                  <td>ONLINE</td>
                 @else
                   <td>PRESENCIAL</td>
                 @endif
                 <td>{{ $inscription->nameCurso }}</td>
                 <td>{{ $inscription->time }}</td>
                 <td>{{ \Carbon\Carbon::parse($inscription->startDate)->format('d/m/Y') }}</td>
                 <td>{{ $inscription->address}}</td>
                 <td>
                  <div class="btn-group btn-group-sm">`

                      <a href="{{ route('inscriptions.show', $inscription->id) }}" class="btn btn-info">
                        <i class="fa fa-list-ul" aria-hidden="true"></i> Consolidado
                      </a>
                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                      <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li>
                          <a href="{{ route('inscriptions.edit', $inscription->id) }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
                          </a>
                        </li>
                      </ul>
                    @endif
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
  //   $('#tb_prom_cur').DataTable({
  //     "processing": true,
  //       "serverSide": true,
  //     "ajax": "{{ route('json_list_prom_curso') }}",
  //     "columns": [
  //     {data: 'id'},
  //     {data: 'nameLocation'},
  //     {data: 'nameCourse'},
  //     {data : 'time'},
  //     {data: 'startDate'},
  //     {data: 'slot'},
  //     {"render": function (data, type, row) {
  //       return '<a href="/users/'+row.id+'" class="editar edit-modal btn btn-warning"><span class="fa fa-edit"></span><span class="hidden-xs"> '+row.id+'</span></a>';
  //     }},
  //     ],
  //     columnDefs: [
  //           { orderable: false, targets: [ 5 ] }
  //           ]
  //         });
});

</script>
@endsection