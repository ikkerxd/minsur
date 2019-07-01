
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Registro de participantes
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Detalle Inscripcion</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-success">             
        <br>
        <div class="box-body table-responsive no-padding">
         @include('layouts.info')
         {!! Form::model($participants, ['route' => ['userInscriptions.update', $id],'method'=>'PUT']) !!}
         <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>  
              <th>DNI</th>
              <th>APELLIDO PATERNO</th>
              <th>APELLIDO MATERNO</th>
              <th>NOMBRES</th>              
              <th>CARGO</th>
              <th>EMPRESA</th>
              <th>SUB-CONTRATA</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($participants as $participant)
           <tr>
             <td><input type="text" class="form-control" name="dni[]" required></td>
             <td><input type="text" class="form-control" name="apa[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required></td>
             <td><input type="text" class="form-control" name="ama[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required></td>
             <td><input type="text" class="form-control" name="name[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required></td>             
             <td><input type="text" class="form-control" name="position[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required></td>
             <td><input type="text" class="form-control" name="company[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required value="{{ $participant->company }}"></td>
             <td><input type="text" class="form-control" name="contrata[]" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" required></td>
             <td><input type="hidden" class="form-control" name="id_participant[]" value="{{ $participant->id }}"></td>
           </tr>
           @endforeach
         </tbody>              
       </table>        
     </div> 
     <div class="box-footer">
      <div class="col-md-2  pull-right">
        <button type="submit" class=" btn btn-primary btn-sm form-control"><i class='fa fa-pencil-square-o' aria-hidden='true'></i> Registrar</button> 
      </div>
    </div>
    {!! Form::close() !!}
  </div>  

</div>
</div>
</section> 
@endsection
