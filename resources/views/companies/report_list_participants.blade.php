
@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-building-o" aria-hidden="true"></i> Reporte de Participantes
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="#">Reporte</a></li>
            <li class="active">Participantes</li>
        </ol>
    </section>

    <section class="content" style="min-height: auto">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Reportes de Participantes</h3>
                    </div>
                    {!! Form::open(['route' => 'report_participants']) !!}
                    <div class="box-body">

                        <div class='col-md-3'>
                            <div class="form-group">
                                {!! Form::label('startDate', 'Fecha de inicio') !!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('startDate', null, ['class' => 'form-control pull-right datepicker','required' => 'required','autocomplete' => 'off']) !!}
                                </div>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                {!! Form::label('endDate', 'Fecha de fin') !!}
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    {!! Form::text('endDate', null, ['class' => 'form-control pull-right datepicker','required' => 'required','autocomplete' => 'off']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" name="action" value="sub" class="btn bg-primary" style=" position: relative;top: 21.5px;">Buscar</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-default">
                    <hr>
                    @if($query)
                        <div class="box-header">
                            <a href="{{ route('export_list_participant', [Auth::id(), Request::get('startDate'), Request::get('endDate')] ) }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o"></i> Descargar</a>
                        </div>
                    @endif
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Dni</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombres</th>
                                <th>Tipo</th>
                                <th>Curso</th>
                                <th>Fecha</th>
                                <th>Nota minima</th>
                                <th>Nota</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($query as $participant)
                                    <tr  class="">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $participant->dni }}</td>
                                        <td>{{ $participant->firstlastname }}</td>
                                        <td>{{ $participant->secondlastname }}</td>
                                        <td>{{ $participant->name }}</td>
                                        @if($participant->payment_form == "a cuenta")
                                            <td>UNDIAD MINERA</td>
                                        @else
                                            <td>EXTRAORDINARIO</td>
                                        @endif
                                        <td>{{ $participant->nameCurso }}</td>
                                        <td>{{ $participant->startDate }} {{ $participant->time }}</td>
                                        <td>{{ $participant->point_min }}</td>
                                        <td>{{ $participant->nota }}</td>
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

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endsection