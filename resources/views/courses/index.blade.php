
@extends('layouts.templates')

@section('content')

<section class="content-header">
    <h1>
        <i class="fa fa-book"></i> Cursos
        <small>Version 1.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Cursos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">

                @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                    <div class="box-header">
                        <div class="input-group input-group-sm">
                            <a href="{{route('courses.create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR CURSO</a>
                        </div>
                    </div>
                @endif

                <br>
                <div class="box-body table-responsive no-padding">
                    @include('layouts.info')
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>TIPO</th>
                            <th>CURSO</th>
                            <th>HORAS</th>
                            <th>VIGENCIA</th>
                            <th>NOTA MINIMA</th>
                            <th>TIPO DE COSTO</th>
                            @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)
                                <th colspan="3">ACCIONES</th>
                            @endif

                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                                <tr>
                                    <td>{{ $course->id }}</td>
                                    <td>{{ $course->nameTypeCourse }}</td>
                                    <td>{{ $course->nameCourse }}</td>
                                    <td>{{ $course->hh }}</td>
                                    <td>
                                        {{ $course->validaty }}
                                        @if($course->type_validaty == 1)
                                            {{ Str::plural('dia', $course->validaty) }}
                                        @endif
                                        @if($course->type_validaty == 2)
                                            {{ Str::plural('mes', $course->validaty) }}
                                        @endif
                                        @if($course->type_validaty == 3)
                                            {{ Str::plural('año', $course->validaty) }}
                                        @endif
                                    </td>
                                    <td>{{ $course->point_min }}</td>
                                    @if($course->required)
                                        <td><small class="label bg-green">Asume minsur</small></td>
                                    @else
                                        <td><small class="label bg-gray">Costo de 2 X 1</small></td>
                                    @endif
                                    @if(Auth::id() <> 2683 && Auth::id() <> 4141 && Auth::id() <> 14078 && Auth::id() <> 1097 && Auth::id() <> 14179 && Auth::id() <> 14180 && Auth::id() <> 7053)

                                        @can('courses.show')
                                            <td width="10px"><a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-default">Ver</a></td>
                                        @endcan
                                        @can('courses.edit')
                                            <td width="10px"><a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
                                        @endcan
                                        @can('courses.destroy')
                                            <td width="10px">

                                                {!! Form::open(['route' => ['courses.destroy', $course->id], 'method' => 'DELETE']) !!}
                                                <button class="btn btn-sm btn-danger btn-delete">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                                {!! Form::close()!!}
                                            </td>
                                        @endcan
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
@endsection
