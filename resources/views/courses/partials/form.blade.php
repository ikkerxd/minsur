<div class="box-body">
  <div class="form-group">    
    {!! Form::label('id_type_course', 'Tipo Curso',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
      {!! Form::select('id_type_course', $type_courses, null, ['class' => 'form-control']) !!}
    </div>
  </div>
  <div class="form-group">    
    {!! Form::label('name', 'Nombre Curso',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
      {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Ingrese nombre curso']) !!}      
    </div>
  </div>

  <div class="form-group">
    {!! Form::label('validaty', 'Vigencia',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
      {!! Form::number('validaty', null, ['class' => 'form-control','placeholder' => '0']) !!}
    </div>
    {!! Form::label('hh', 'Horas',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
      {!! Form::number('hh', null, ['class' => 'form-control','placeholder' => '0']) !!}
    </div>

    {!! Form::label('point_min', 'Nota minima',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-2">
      {!! Form::number('point_min', null, ['class' => 'form-control','placeholder' => '0']) !!}
    </div>

  </div>

  <div class="checkbox">
    <label>
      {!! Form::checkbox('required', null) !!} ¿Es curso de pago unico?
    </label>
  </div>
</div>

<div class="box-footer">
  <a href="{{route('courses.index')}}" class="btn btn-default">Cancelar</a>  
  {!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>
              