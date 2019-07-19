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
                    <div class="col-sm-4">
                        {!! Form::open(['route' => 'search_participant_contrata','method' => 'post', 'class' => 'form-search', 'role'=>'search']) !!}
                            <div class="input-group input-group-sm">
                                {!! Form::text('dni', null, ['class' => 'form-control', 'placeholder' => 'Ingrese Doc. identidad']) !!}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                                </span>
                            </div>
                        {!! Form::close() !!}
                    </div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="col-sm-12">

                            <table class="table table-bordered text-center" id="datatable">
                                <thead>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombres</th>
                                    <th>Empresa</th>
                                    <th>Condicion</th>
                                    <th>Consolidado</th>
                                    <th>Accion</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($query as $user)
                                    <tr data-id="{{ $user->id }}">
                                        <td>{{ $user->dni }}</td>
                                        <td>{{ $user->firstlastname }} {{ $user->secondlastname }} {{ $user->name }}</td>
                                        <td>{{ $user->empresa }}</td>
                                        <td>
                                            @if ($user->state == 0)
                                                <small class="label bg-green-active"> Activo</small>
                                            @else
                                                <small class="label bg-danger">Inactivo</small>
                                            @endif
                                        </td>
                                        <td><a href="{{ route('detail-participant', $user->id) }}" class="btn btn-sm btn-info">Consolidado</a></td>
                                        <td>
                                            <a class="btn btn-sm btn-primary btn-change">Cambiar de empresa</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">{{ $mensaje }}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table> <!-- tabla-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {!! Form::open(['route' => ['change_company', 'id' => ':USER_ID'], 'method' => 'POST',  'id' => 'form-change']) !!}
    {!! Form::close() !!}

@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        });

        $('.btn-change').click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Esta seguro que deseas cambiar de empresa al participante?',
                text: "si esta de acuerdo click al botón azul",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Cambiar!'
            }).then((result) => {
                if (result.value) {
                    const row = $(this).parents('tr');
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
                            console.log(data);
                            row.children('td:nth-child(3)').text(data.name);
                            row.find('small').addClass('bg-green-active').text("Activo");
                            row.find('.btn-change').addClass('disabled');

                            Swal.fire(
                                'Felicitaciones!',
                                data.message,
                                'success'
                            );
                        });
                }
            })
        });
    </script>
@endsection