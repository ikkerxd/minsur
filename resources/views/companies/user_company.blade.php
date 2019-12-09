@extends('layouts.templates')

@section('content')

    <section class="content-header">
        <h1>
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Usuario: {{ $company[0]->businessName }}
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Editar Perfil</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Perfil de {{ $user->email }}</h3>
                    </div>

                    {!! Form::model($user, ['route' => ['update_user_company', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal','files' => true]) !!}
                    @include('participants.partials.form_contrata')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
