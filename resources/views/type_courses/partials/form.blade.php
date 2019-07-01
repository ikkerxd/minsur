<div class="box-body">
  <div class="form-group">    
    {!! Form::label('name', 'Nombre Tipo Curso',['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">      
      {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Ingrese nombre tipo curso','required' => 'required']) !!}
    </div>
  </div>      
</div>
<!-- /.box-body -->
<div class="box-footer">
  <a href="{{route('type_courses.index')}}" class="btn btn-default">Cancelar</a>  
  {!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>
              