<div class="box-body">

 <div class='col-md-12'>    
 	<div class='form-group'>
 		{!! Form::label('id_course', 'Curso') !!}
 		{!! Form::select('id_course', $courses, null, ['class' => 'form-control select2','style' => 'width: 100%;']) !!}
 	</div>
 </div>

 <div class='col-md-4'>
 	<div class='form-group'>
 		{!! Form::label('id_location', 'Lugar') !!}
 		{!! Form::select('id_location', $locations, null, ['class' => 'form-control']) !!}
 	</div>
 </div>
 <div class='col-md-8'>
 	<div class='form-group'>
 		{!! Form::label('address', 'Dirección') !!}
 		{!! Form::text('address', null, ['class' => 'form-control','placeholder' => 'Ingresa dirección','required' => 'required']) !!}
 	</div>
 </div>
 <div class='col-md-3'>
 	<div class="form-group">
 		{!! Form::label('startDate', 'Fecha') !!}
 		<div class="input-group date">
 			<div class="input-group-addon">
 				<i class="fa fa-calendar"></i>
 			</div> 			
 			{!! Form::text('startDate', null, ['class' => 'form-control pull-right datepicker','required' => 'required','autocomplete' => 'off']) !!}
 		</div>                
 	</div>
 </div>
 <div class='col-md-3'>
 	<div class="form-group">
 		{!! Form::label('time', 'Hora') !!}
 		<div class="input-group"> 			
 			{!! Form::text('time', null, ['class' => 'form-control timepicker','required' => 'required','value' => '08:00']) !!}
 			<div class="input-group-addon">
 				<i class="fa fa-clock-o"></i>
 			</div>
 		</div>
 	</div>
 </div>

<div class='col-md-6'>
 	<div class="form-group">
 		{!! Form::label('users', 'Facilitador') !!}
 		<div class="input-group date">
 			<div class="input-group-addon">
 				<i class="fa fa-user-circle-o"></i>
 			</div>
			{!! Form::select('id_user', $users, null, ['class' => 'form-control']) !!}

 		</div>                
 	</div>
 </div>

</div>
<!-- /.box-body -->
<div class="box-footer">
	<a href="{{route('inscriptions.index')}}" class="btn btn-default">Cancelar</a>  
	{!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>