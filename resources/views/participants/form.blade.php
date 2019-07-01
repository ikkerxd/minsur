<div class="box-body">
  @include('layouts.info')
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
  </div>
  {{-- FIN COLUMNA IZQUIERDA --}}

{{-- @php
  echo $foo = ucfirst('luis vega');
@endphp --}}

  {{-- COLUMNA DERECHA --}}
  <div class="col-md-6">
   {{-- <div class="form-group">    
    <img src="/participants/{{ $users->image_hash }}" class="img-responsive center-block">
  </div> --}}
  
  <div class="form-group">
    {!! Form::label('image', 'Foto',['class' => 'col-md-4 control-label']) !!}
    <div class="col-md-7">      
      {!! Form::file('image',['class' => 'form-control', 'style'=> 'border: 0px solid']) !!}
    </div>
  </div>

  <div class="form-group">    
      {!! Form::label('phone', 'Celular',['class' => 'col-md-4 control-label']) !!}
      <div class="col-md-7">      
        {!! Form::text('phone', null, ['class' => 'form-control','required' => 'required']) !!}
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



</div>
{{-- FIN COLUMNA DERECHA --}}
</div>

</div>

<div class="box-footer">
  {{ Form::hidden('type_register',1) }}
  {!! Html::linkRoute('list_participants', 'Cancelar  ', null, array('class' => 'btn btn-default')) !!}
  {!! Form::submit('GUARDAR', ['class' => 'btn btn-info pull-right btn_submit_register']) !!}
</div>
