
@extends('layouts.templates')

@section('content')

    <section class="content-header">
      <h1>
        <i class="fa fa-building-o" aria-hidden="true"></i> Empresas
        <small>Version 1.0</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Configuracion</a></li>
        <li class="active">Empresas</li>
      </ol>
    </section>
    
    <section class="content">
      <div class="row">
        <div class="col-md-6">          
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registar Nueva Empresa</h3>
            </div>           
            {!! Form::open(['route' => 'companies.store', 'class' => 'form-horizontal']) !!}
                @include('companies.partials.form')
            {!! Form::close() !!}
          </div>         
        </div>
      </div>
    </section> 
@endsection
