
@extends('layouts.templates')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Participantes
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Participantes</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                        <div class="box-header">
                            <div class="input-group input-group-sm">
                                <a href="{{ route('new_participant') }}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR PARTICIPANTES</a>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="box-body table-responsive no-padding">
                        @include('layouts.info')
                        <table class="table table-bordered table-striped" id="datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DNI</th>
                                <th>NOMBRES COMPLETOS</th>
                                <th>CARGO</th>
                                <th>AREA/CONTRATA</th>
                                <th class="text-center">INFORMACION</th>

                                @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                    <th>OPCIONES</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody style="font-size: 1rem">
                            @foreach ($participants as $participant)
                                <tr data-id="{{ $participant->id }}" >
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $participant->dni }}</td>
                                    <td>{{ $participant->name }} {{ $participant->firstlastname }} {{ $participant->secondlastname }}</td>
                                    <td>{{ $participant->position }}</td>
                                    <td>{{ $participant->superintendence }}</td>
                                    <td  class="text-center"><a href="{{ route('detail-participant', $participant->id) }}" class="btn btn-sm btn-success"><i class="fa fa-list-alt" aria-hidden="true"></i> Consolidado</a></td>
                                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)
                                        <td>
                                            <a href="{{ route('edit_participant',Crypt::encryptString($participant->id)) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            <a class="btn btn-danger btn-sm btn-desactivate"><i class="fa fa-trash"></i></a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {!! Form::open(['route' => ['desactivate_participant', 'id' => ':USER_ID'], 'method' => 'POST',  'id' => 'form-change']) !!}
    {!! Form::close() !!}

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                "stateSave": true,
                "processing": true,
            });
            $('#datatable tbody').on('click', 'tr .btn-desactivate', function (e) {
                e.preventDefault();
                //Recueramos el to el row
                const row = $(this).parents('tr');
                const nombres = row.children('td:nth-child(3)').text();
                Swal.fire({
                    title: '¿Esta seguro que deseas desactivar el particpante ' + nombres + '?',
                    text: "si esta de acuerdo click al botón rojo",
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Si, Desativar!'
                }).then((result) => {
                    if (result.value) {
                        const id = row.data('id');
                        const form = $('#form-change');
                        const url = form.attr('action').replace(':USER_ID', id);
                        const data = form.serialize();

                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: data,
                        })
                            .done(function(data) {
                                row.fadeOut();
                                Swal.fire(
                                    'Felicitaciones!',
                                    data.message,
                                    'success'
                                );
                            });
                    }
                })
            });
        });
    </script>
@endsection
