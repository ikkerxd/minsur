
@extends('layouts.templates')

@section('content')

<section class="content-header">
    <h1>
        <i class="fa fa-book"></i> Lista de Cursos
        <small>Version 1.0</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Lista de Cursos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-header">


                </div>
                <br>
                <div class="box-body table-responsive no-padding">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>CURSO</th>
                            <th>&nbsp;ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($query as $course)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $course->name }}</td>

                            <td width="100px">
                                <a href="{{ route('export_course', $course->id) }}" class="btn btn-sm btn-success">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('course_certificado', $course->id) }}" class="btn btn-sm btn-danger">
                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                </a>
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
