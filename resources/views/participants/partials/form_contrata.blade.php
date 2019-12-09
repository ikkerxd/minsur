<div class="box-body">
    @include('layouts.info')
	<div class="row">
    {{-- COLUMNA IZQUIERDA --}}
        <div class="col-md-12">

            <div class="form-group">
              {!! Form::label('dni', 'Documento Identidad',['class' => 'col-md-2 control-label']) !!}

              <div class="col-md-10">
                {!! Form::text('dni', null, ['class' => 'form-control','required' => 'required']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('firstlastname', 'Apellido Paterno',['class' => 'col-md-2 control-label']) !!}
              <div class="col-md-10">
                {!! Form::text('firstlastname', null, ['class' => 'form-control','required' => 'required']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('secondlastname', 'Apellido Materno',['class' => 'col-md-2 control-label']) !!}
              <div class="col-md-10">
                {!! Form::text('secondlastname', null, ['class' => 'form-control','required' => 'required']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('name', 'Nombres',['class' => 'col-md-2 control-label']) !!}
              <div class="col-md-10">
                {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('email_valorization', 'Email de Valorizacion:',['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('email_valorization', null, ['class' => 'form-control']) !!}
                </div>
                <span id="helpBlock" class="help-block" style="padding-left: 15px">Ingrese el o los correos al cual se les van a enviar la valorizaciones y facturas separados por " , ".</span>
            </div>

            <div class="form-group">
                {!! Form::label('phone', 'Telefono de contacto:',['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                </div>
                <span id="helpBlock" class="help-block">Ingrese el o los  Telefono contacto. " , ".</span>
            </div>

        </div>
    </div>

</div>

<div class="box-footer">
        {{ Form::hidden('email','mail@mail.com') }}
        @if( Auth::id() === $user->id )
            <a href="{{ route('home') }}" class="btn btn-default">Cancelar</a>
        @else
            <a href="{{ route('companies.index') }}" class="btn btn-default">Cancelar</a>
        @endif

        {!! Form::submit('GUARDAR', ['class' => 'btn btn-info pull-right']) !!}{{ Form::hidden('type_register',1) }}
</div>
