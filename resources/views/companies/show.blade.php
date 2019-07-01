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

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header text-center">
          <br>
          <h3 class="box-title"><strong>{{$company->businessName}}</strong></h3>
          <h4>{{$company->ruc}}</h4>
        </div>

        <div class="box-body table-responsive no-padding">

            <table class="table" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>dni</th>
                  <th>Nombres</th>
                  <th>Cargo</th>
                  <th>Area</th>
                  <th>estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->dni }}</td>
                  <td>{{ $user->name  }} {{ $user->firstlastname  }} {{ $user->secondlastname  }}</td>
                  <td>{{ $user->position }}</td>
                  <td>{{ $user->superintendence }}</td>
                  @if($user->state == 0)
                    <td>activo</td>
                  @else
                    <td>anulado</td>
                  @endif
                  <td>
                    <a href="#" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal{{ $user->id }}">Ver</a>
                  </td>
                </tr>
                <div class="modal fade" id="myModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $user->id }}" aria-hidden="true">

                  <div class="modal-dialog">


                    <div class="modal-content">
                      <div class="modal-header" style="background: #2980b9;color:white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><strong>DATOS DEL USUARIO</strong></h4>
                      </div>
                      <div class="modal-body text-center" style="font-size: 15px">
                        <p><i class="fa fa-user-circle" aria-hidden="true"></i> {{ $user->name  }} {{ $user->firstlastname  }} {{ $user->secondlastname  }}</p>
                        <hr>
                        <p><i class="fa fa-phone-square" aria-hidden="true"></i> {{ $user->position }}</p>
                        <hr>
                        <p><i class="fa fa-phone-square" aria-hidden="true"></i> {{ $user->superintendence }}</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>

                  </div>
                </div>

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