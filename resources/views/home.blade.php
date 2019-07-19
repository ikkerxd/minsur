@extends('layouts.templates')

@section('content')
<section class="content">      
    @role('admin-general')
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $companies }}</h3>

              <p>Empresas</p>
            </div>
            <div class="icon">
              <i class="ion ion-pricetags"></i>
            </div>
            <a href="{{route('companies.index')}}" class="small-box-footer">Más info.<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $users }}</h3>
              <p>Usuarios IGH</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-contact"></i>
            </div>
            <a href="{{route('users.index')}}" class="small-box-footer">Más info.<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $inscriptions}}</h3>

              <p>Apertura de Cursos</p>
            </div>
            <div class="icon">
              <i class="ion-compose"></i>
            </div>
            <a href="{{route('inscriptions.index')}}" class="small-box-footer">Más info.<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $participants }}</h3>

              <p>Participantes</p>
            </div>
            <div class="icon">
              <i class="ion-person-stalker"></i>
            </div>
            <a href="#" class="small-box-footer">Más info.<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-md-12">
         <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Recientes Registros de Participantes</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <th>#</th>
                  <th>RUC</th>
                  <th>EMPRESA</th>
                  <th>CURSO</th>
                  <th>FECHA</th>
                  <th>ESTADO</th>
                  <th>FECHA HORA INSCRIPCION</th>
                </thead>
                <tbody>
                  @foreach ($detail_order_services as $detail_order_service)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <th><a href="#">{{ $detail_order_service->ruc }}</a></th>
                    <th>{{ $detail_order_service->businessName }}</th>
                    <th>{{ $detail_order_service->courseName }}</th>
                    <th>{{ $detail_order_service->fecha }}</th>
                    <th>
                      @if ($detail_order_service->state == 0)
                        <span class="label label-primary">Normal</span>
                      @elseif($detail_order_service->state == 1)
                        <span class="label label-info">Programado</span>
                      @else
                        <span class="label label-danger">Anulado</span>
                      @endif
                    </th>
                    <th>{{ $detail_order_service->created_at }}</th>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    @endrole

    @role('admin-cont')
        <div class="row">
          <div class="col-md-12">

         </div>
        </div>
    @endrole

@role('super-sis')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger text-center">
          <div class="box-body" style="background: #e74c3c;color:white;font-weight: bold;">
              <h1><i class="fa fa-user-md fa-4x" aria-hidden="true"></i></h1>
              <h2>Centro Médico -  Las Bambas</h2>
              <br>
             <a href="{{ route('medical_center') }}" class="btn btn-success">BUSCAR PERSONAL</a>
             <br><br>
         </div>
          <div class="box-footer clearfix">
            <p>ENVIAR LA DATA EN EXCEL AL TERMINAR EL CURSO AL CORREO <a href="mailto:soporte@ighgroup.com">soporte@ighgroup.com</a></p>
          </div>
       </div>
     </div>
    </div>
@endrole

</section>
@endsection


@section('script')
<script>
 // $('#myModal').modal('show');
</script>
@endsection

