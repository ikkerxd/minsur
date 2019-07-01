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
                                    <tr>
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
                                            <form action="{{ route('change_company', ['id' =>  $user->id ])}}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <a class="btn btn-sm btn-primary charapa">Cambiar de empresa</a>
                                            </form>

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
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.charapa').click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Seguro que deseas reprogramar?',
                    text: "si esta deacuerdo clic al boton azul",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Reprogramar!'
                }).then((result) => {
                    if (result.value) {
                        const form = $(this).parents('form');
                        const url = form.attr('action');
                        console.log(url);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                            data: $(this).serialize(),
                        })
                        .done(function(data) {
                            console.log('amigo');
                            console.log(data);
                            Swal.fire(
                                'Felicitaciones!',
                                'Sus participantes han sido programados.',
                                'success'
                            );
                            window.location.href = "company/search-participant";
                        });
                    }
                })
            });

        });
    </script>
@endsection