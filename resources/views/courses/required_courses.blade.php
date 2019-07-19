
@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Lista de participantes que pasaron el curso obligatorio.
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
                <div class="box box-primary">
                    <div class="box-header">
                        <div>
                            @if($participants != [])
                                <a href="{{ route('export_required_courses_participants') }}"
                                   class="btn btn-success btn-sm pull-right">
                                    <i class="fa fa-download"></i> Exportar
                                </a>
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="box-body table-responsive">
                        @include('layouts.info')
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DNI</th>
                                <th>NOMBRES COMPLETOS</th>
                                <th>AREA/CONTRATA</th>
                                @forelse($coursesRequired as $course)
                                    <th >{{ $course->name }}</th>
                                @empty

                                @endforelse

                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($participants as $participant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $participant->dni }}</td>
                                    <td>{{ $participant->participante }}</td>
                                    <td>{{ $participant->superintendence }}</td>

                                    @if($participant->obligatorio1)
                                        <td><small class="label label-success">SI</small></td>
                                    @else
                                        <td><small class="label label-warning">NO</small></td>
                                    @endif

                                </tr>
                            @empty
                                <tr>
                                    <td>No hay curso obligatorio en la presente fecha</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
