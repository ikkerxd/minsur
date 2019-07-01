<div class="box-body">
	<div class="form-group">    
		{!! Form::label('name', 'Nombre Role',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-4">      
			{!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Ingrese nombre de Role']) !!}
		</div>
	</div>

	<div class="form-group">    
		{!! Form::label('slug', 'URL Amigable',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-10">      
			{!! Form::text('slug', null, ['class' => 'form-control','placeholder' => 'Ingrese una url-amigable']) !!}
		</div>
	</div>

	<div class="form-group">    
		{!! Form::label('description', 'Descripción',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-10">      
			{!! Form::textarea('description', null, ['class' => 'form-control','placeholder' => 'Ingrese una descripcion']) !!}
		</div>
	</div>

	<div class="form-group">
		{!! Form::label('special', 'Acceso',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-10">      
			{{ Form::radio('special', 'all-access') }}  Total			
			{{ Form::radio('special', 'no-access') }} Ningun acceso
		</div>
	</div> 

	<div class="form-group">
		{!! Form::label('permission', 'Lista de Permisos',['class' => 'col-sm-2 control-label']) !!}
		<div class="col-sm-10">      
			<ul style="list-style:none">
			@foreach($permissions as $permission)
			<li>
				{{Form::checkbox('permissions[]', $permission->id, null)}}
				{{$permission->name}}
				<em>({{$permission->description ?: 'Sin descripcion'}})</em>		
			</li>
			@endforeach
		</ul>
		</div>
	</div>   
</div>

<div class="box-footer">
	<a href="{{route('roles.index')}}" class="btn btn-default">Cancelar</a>  
	{!! Form::submit('REGISTRAR', ['class' => 'btn btn-info pull-right']) !!}
</div>