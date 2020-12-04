@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-pencil-square-o"></i> Apertura Curso
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Configuracion</a></li>
            <li class="active">Inscripción</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="text-transform: uppercase;">{{ $inscription->nameCurso }}
                            <small>CONSOLIDADO DE PARTICIPANTES INSCRITOS</small>
                        </h3>

                        <div class="btn-group pull-right" role="group" >
                            <a href="{{ route('export_inscription', ['id' => Request::segment(2)]) }}"
                               class="btn btn-success btn-sm"><i class="fa fa-cloud-download" aria-hidden="true"></i> Exportar a Excel
                            </a>

                            @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                    Subir Notas
                                </button>
                            @endif
                        </div>

                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table text-center table table-bordered" style="text-transform: uppercase">
                            <tr>
                                <th>SEDE:</th><td>{{$inscription->nameLocation}}</td>
                                <th>FECHA:</th><td>{{$inscription->startDate}}</td>
                                <th>HORA:</th><td>{{$inscription->time}}</td>
                                <th>DURACION (hr):</th><td>{{$inscription->hours}}</td>
                            </tr>
                            <tr>
                                <th>DIRECCION: </th><td colspan="5">{{ $inscription->address }}</td>
                                <th>FACILITADOR: </th><td>{{ $inscription->firstName." ".$inscription->nameUser }}</td>
                            </tr>
                            <tr>
                                <th  colspan="8"></th>
                            </tr>
                            <tr>
                                <th  colspan="8"> DATOS DE LA REUNION</th>
                            </tr>
                            <tr>
                                <th>PLATAFORMA: </th><td>{{ $inscription->platform }}</td>
                                <th>CODIGO DE LA REUNION: </th><td colspan="2">{{ $inscription->platform_id }}</td>
                                <th>CLAVE DE LA REUNION: </th><td colspan="2">{{ $inscription->platform_pwd }}</td>
                            </tr>

                            <tr>
                                <th>ENLACE DE LA REUNION: </th><td colspan="7">{{ $inscription->platform_url }}</td>
                            </tr>
                            <tr>
                                <th>ENLACE DE LA EVALUACION: </th><td colspan="7">{{ $inscription->test_url }}</td>
                            </tr>

                        </table>
                        <br>
                        <div id="alert" class="alert alert-info"></div>
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Empresa Actual</th>
                                <th>Empresa Que Paso el Curso</th>
                                <th>Condicion</th>
                                <th>Nota</th>
                                @if($inscription->id_course == 8)
                                    <th>Sustitutorio</th>
                                @endif
                                @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                    <th>Anular</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody style="text-transform: uppercase">
                            @foreach ($participants as $participant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $participant->dni }}</td>
                                    <td>{{ $participant->firstlastname }} {{ $participant->secondlastname }} {{ $participant->name }}</td>
                                    <td>{{ $participant->businessName }}</td>
                                    <td>
                                        @if( $participant->previous_company == 'IGH GROUP')
                                            Minsur S. A.
                                        @else
                                            {{ $participant->previous_company }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($participant->state == 0)
                                        @else
                                            <small class="label label-info">Reprogramado</small>
                                        @endif
                                    </td>
                                    <td>{{ $participant->point }}</td>
                                    @if($inscription->id_course == 8)
                                        <td>{{ $participant->sustitutorio }}</td>
                                    @endif
                                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)
                                        <td>
                                            <form action="{{ route('anulate_user_inscription', ['id' =>  $participant->id ])}}" method="post">
                                                {{ csrf_field() }}
                                                <a class="btn btn-xs btn-danger btn-anulate" style="text-transform: capitalize" title="Anular registro" data-toggle="tooltip" data-placement="top">Anular</a>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table> <!-- -->
                    </div>     <!-- fin de box body-->
                </div>       <!-- fin de box -->
            </div> <!-- fin de col -->
        </div> <!-- fin de row -->

        @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Subir notas de la inscripcion</h4>
                    </div>
                    <form action="{{ route('import_inscription', ['id' => Request::segment(2)]) }}" enctype="multipart/form-data" method="post" >
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="file_up">Archivo</label>
                                <input id="file_up" name="file_up" type="file" accept=".xlsx">
                                <p class="help-block">Subir archivos con formato .xlsx</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn bg-light-blue btn-sm">Cargar</button>
                        </div>

                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        @endif
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#alert').hide();
            $('.btn-anulate').click(function (e) {
                e.preventDefault();
                if (! confirm('¿Esta seguro de eliminar?')) {
                    return false;
                }
                var row = $(this).parents('tr');
                var form = $(this).parents('form');
                var url = form.attr('action');
                console.log(url);
                $('#alert').show();

                $.post(url, form.serialize(), function (result) {
                    row.fadeOut();
                    $('#alert').html(result.message);
                }).fail(function () {
                    $('#alert').html('Algo salio mal');
                })
            })
        });
    </script>

@endsection