<div class="box-body">
  <div class="form-group">    
    {!! Form::label('ruc', 'Ruc',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">      
      {!! Form::text('ruc', null, ['class' => 'form-control','placeholder' => 'Ingrese su numero RUC']) !!}
    </div>
  </div>
  <div class="form-group">    
    {!! Form::label('businessName', 'Razon Social',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">      
      {!! Form::text('businessName', null, ['class' => 'form-control','placeholder' => 'Ingrese su razon social','style' => 'text-transform:uppercase','onkeyup' => 'javascript:this.value=this.value.toUpperCase();']) !!}      
    </div>
  </div>
  <div class="form-group">    
    {!! Form::label('address', 'Direccion',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">      
      {!! Form::text('address', null, ['class' => 'form-control','placeholder' => 'Ingrese su direccion']) !!}
    </div>
  </div>
  <div class="form-group">    
    {!! Form::label('phone', 'Telefono',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">      
      {!! Form::text('phone', null, ['class' => 'form-control','placeholder' => 'Ingrese su telefono (OPCIONAL)']) !!}
    </div>
  </div>                
</div>
<!-- /.box-body -->
<div class="box-footer">
  {!! Html::linkRoute('companies.index', 'Cancel', null, array('class' => 'btn btn-default')) !!}  
  {!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>
              