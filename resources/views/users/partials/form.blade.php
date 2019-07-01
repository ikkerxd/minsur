<div class="box-body">
	<div class="row">
    {{-- COLUMNA IZQUIERDA --}}


    <div class="col-md-6">

      @php
      $type_document = array(0 => 'DNI', 1 => 'Carnet de Extrangeria', 2 => 'Pasaporte');
      $gender = array(0 => 'Masculino', 1 => 'Femenino');
      $origin = array(0 => 'Lima', 1 => 'Arequipa',2 => 'Cusco');
        //CARGO
        //GERENCIA
        //SUPERINTENDENCIA
      @endphp

      <div class="form-group">    
        {!! Form::label('id_company', 'Empresa',['class' => 'col-md-4 control-label']) !!}
        <div class="col-sm-7">      
          {!! Form::select('id_company', $companies, null, ['class' => 'form-control select2','style' => 'width: 100%;']) !!}
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('dni', 'Documento Identidad',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-3">      
          {!! Form::select('type_document', $type_document, null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4">      
          {!! Form::text('dni', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
      </div> 

      <div class="form-group">    
        {!! Form::label('firstlastname', 'Apellido Paterno',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::text('firstlastname', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('secondlastname', 'Apellido Materno',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::text('secondlastname', null, ['class' => 'form-control','required' => 'required']) !!}      
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('name', 'Nombres Completos',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('birth_date', 'Fecha Nacimiento',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::date('birth_date', null, ['class' => 'form-control']) !!}      
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('email', 'Correo electronico',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::email('email', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
      </div>

      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">    
        {!! Form::label('password', 'Contraseña',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">      
          {!! Form::password('password', ['class' => 'form-control','placeholder' => 'Ingrese su contraseña','required' => 'required']) !!}
          @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
          @endif
        </div>
      </div>

      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">    
        {!! Form::label('password-confirm', 'Confirmar Contraseña',['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-7">      
          {!! Form::password('password-confirm', ['class' => 'form-control','placeholder' => 'Ingrese su contraseña','required' => 'required']) !!}     
        </div>
      </div>


      <div class="form-group">    
        {!! Form::label('gender', 'Género',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::select('gender', $gender, null, ['class' => 'form-control']) !!}    
        </div>
      </div>

      <div class="form-group">    
        {!! Form::label('position', 'Cargo',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::text('position', null, ['class' => 'form-control']) !!}
        </div>
      </div> 

      <div class="form-group">    
        {!! Form::label('phone', 'Celular',['class' => 'col-md-4 control-label']) !!}
        <div class="col-md-7">      
          {!! Form::text('phone', null, ['class' => 'form-control','required' => 'required']) !!}
        </div>
      </div> 


    </div>
    {{-- FIN COLUMNA IZQUIERDA --}}

{{-- @php
  echo $foo = ucfirst('luis vega');
  @endphp --}}

  {{-- COLUMNA DERECHA --}}
  <div class="col-md-6">
   {{--<div class="form-group">    
    <img src="{{ asset('img/avatar_part.svg') }}" class="col-md-3 col-md-offset-4 control-label" height="85px">
  </div>--}}
  
  <div class="form-group">
    {!! Form::label('image', 'Foto',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-6">      
      {!! Form::file('image',['class' => 'form-control', 'style'=> 'border: 0px solid']) !!}
    </div>
  </div>

  <div class="form-group">    
    {!! Form::label('origin', 'Lugar Procedencia',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::select('origin', $origin, null, ['class' => 'form-control']) !!}    
    </div>
  </div>


  <div class="form-group">    
    {!! Form::label('address', 'Dirección',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::text('address', null, ['class' => 'form-control']) !!}      
    </div>
  </div>
  
  <div class="form-group">    
    {!! Form::label('medical_exam', 'Examen Médico',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::date('medical_exam', null, ['class' => 'form-control']) !!}      
    </div>
  </div>

  <div class="form-group">    
    {!! Form::label('management', 'Gerencia',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::select('id_management',$managements,null, ['class' => 'form-control']) !!}      
    </div>
  </div>

  <div class="form-group">    
    {!! Form::label('superintendence', 'Superintendencia',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::text('superintendence', null, ['class' => 'form-control']) !!}      
    </div>
  </div>


  <div class="form-group">    
    {!! Form::label('code_bloqueo', 'Codigo de Llave (Bloqueo)',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::text('code_bloqueo', null, ['class' => 'form-control']) !!}      
    </div>
  </div>

  <div class="form-group">    
    {!! Form::label('roles', 'Role',['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-7">      
     <ul class="list-unstyled">
      @foreach($roles as $role)
      <li>
       <label>
        {{Form::checkbox('roles[]', $role->id, null)}}
        {{$role->name}}
        <em>({{$role->description ?: 'Sin descripcion'}})</em>
      </label>
    </li>
    @endforeach
  </ul>
</div>
</div>  



</div>
{{-- FIN COLUMNA DERECHA --}}
</div>

</div>

<div class="box-footer">
  {{ Form::hidden('type_register',1) }}
  {!! Html::linkRoute('list_participants', 'Cancel', null, array('class' => 'btn btn-default')) !!}
  {!! Form::submit('GUARDAR', ['class' => 'btn btn-info pull-right']) !!}
</div>


{{-- 

<div class="box-body">

	<div class="form-group">
    {!! Form::label('image', 'Foto',['class' => 'col-md-3 control-label']) !!}
    <div class="col-sm-6">      
      {!! Form::file('image',['class' => 'form-control', 'style'=> 'border: 0px solid']) !!}
    </div>
  </div>

	<div class="form-group">    
		{!! Form::label('id_company', 'Empresa',['class' => 'col-md-3 control-label']) !!}
		<div class="col-sm-6">      
			{!! Form::select('id_company', $companies, null, ['class' => 'form-control select2','style' => 'width: 100%;']) !!}
		</div>
	</div>

	<div class="form-group">    
		{!! Form::label('dni', 'DNI',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-3">      
			{!! Form::text('dni', null, ['class' => 'form-control','placeholder' => 'Ingrese DNI','required' => 'required']) !!}
		</div>
	</div> 

	<div class="form-group">    
		{!! Form::label('name', 'Nombre del usuario',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			{!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Ingrese nombre usuario','required' => 'required']) !!}
		</div>
	</div> 

	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">    
		{!! Form::label('email', 'Correo',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			{!! Form::email('email', null, ['class' => 'form-control','placeholder' => 'Ingrese correo electronico','required' => 'required','value' => "{{ old('email') }}"]) !!}
			@if ($errors->has('email'))
			<span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			</span>
			@endif
		</div>
	</div>

	<div class="form-group">    
		{!! Form::label('phone', 'Telefono / Celular',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			{!! Form::text('phone', null, ['class' => 'form-control','placeholder' => 'Ingrese telefono','required' => 'required']) !!}
		</div>
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">    
		{!! Form::label('password', 'Contraseña',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			{!! Form::password('password', ['class' => 'form-control','placeholder' => 'Ingrese su contraseña','required' => 'required']) !!}
			@if ($errors->has('password'))
			<span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			</span>
			@endif
		</div>
	</div>

	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">    
		{!! Form::label('password-confirm', 'Confirmar Contraseña',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			{!! Form::password('password-confirm', ['class' => 'form-control','placeholder' => 'Ingrese su contraseña','required' => 'required']) !!}			
		</div>
	</div>

	<div class="form-group">    
		{!! Form::label('roles', 'Role',['class' => 'col-sm-3 control-label']) !!}
		<div class="col-sm-9">      
			<ul class="list-unstyled">
				@foreach($roles as $role)
				<li>
					<label>
						{{Form::checkbox('roles[]', $role->id, null)}}
						{{$role->name}}
						<em>({{$role->description ?: 'Sin descripcion'}})</em>
					</label>
				</li>
				@endforeach
			</ul>
		</div>
	</div>      
</div>

<div class="box-footer">
	<a href="{{route('users.index')}}" class="btn btn-default">Cancelar</a>  
	{!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>
 --}}