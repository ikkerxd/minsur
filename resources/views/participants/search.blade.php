@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-search" aria-hidden="true"></i> Participante
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Buscar Participante</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="col-sm-12">
                            <h3 class="box-title">Buscar Participante</h3>
                        </div>
                        <br>
                        <br>
                        <div class="col-sm-12">
                            <table class="table table-bordered text-center" id="datatable">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DNI</th>
                                    <th>Nombres</th>
                                    <th>Empresa</th>
                                    <th>Condicion</th>
                                    <th>Cursos</th>
                                    <th>bloquear</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr data-id="{{ $user->id }}" >
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->dni }}</td>
                                        <td>{{ $user->firstlastname }} {{ $user->secondlastname }} {{ $user->name }}</td>
                                        <td>{{ $user->empresa }}</td>
                                        <td>
                                            @if ($user->state == 0)
                                                <small class="label label-success">Activo</small>
                                            @else
                                                <smal class="label label-danger">Inactivo</smal>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('detail-participant', $user->id) }}" class="btn btn-xs btn-primary">Consolidado</a></td>
                                        <td>
                                        @if ($user->state == 0)
                                            <a class="btn btn-xs btn-danger btn-desactivate">Desactivar</a>
                                        @else
                                            <a class="btn btn-xs btn-danger btn-desactivate disabled">Desactivar</a>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table> <!-- tabla-->
                        </div>
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
                                //row.children('td:nth-child(5)').text(data.name);
                                row.find('small').removeClass('label-success').addClass('label-danger').text("Inactivo");
                                row.find('.btn-desactivate').addClass('disabled');

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