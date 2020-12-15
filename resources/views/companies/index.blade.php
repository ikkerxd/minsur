
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
                            @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                <a href="{{route('companies.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR EMPRESA</a>
                            @endif
                        </div>
                    </div>
                    <br>
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
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td>{{ $company->id_company }}</td>
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
                                    <td>
                                        <a href="{{ route('companies.show', $company->id_company) }}" class="btn btn-xs btn-primary" title="Ver detalle" data-toggle="tooltip" data-placement="top">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                            <a href="{{ route('edit_user_company', $company->id_user) }}" class="btn btn-xs btn-warning" title="Editar datos" data-toggle="tooltip" data-placement="top">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        @endif
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
@endsection
