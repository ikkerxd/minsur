
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-users"></i> Participantes
    <small>Version 1.0</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Participantes</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-header">          
          <div class="input-group input-group-sm">
            <a href="{{ route('new_participant') }}" class="btn btn-success btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> REGISTRAR PARTICIPANTES</a>                 
          </div>          
        </div>         
        <br>
        <div class="box-body table-responsive no-padding">
         @include('layouts.info')             
         <table class="table table-bordered table-striped">
          <thead>
            <tr>                            
                <th>#</th>
                <th>DNI</th>
                <th>NOMBRES COMPLETOS</th>
                <th>CARGO</th>
                <th>AREA/CONTRATA</th>
                <th class="text-center">INFORMACION</th>
                <th>OPC.</th>
            </tr>
          </thead>
          <tbody>
           @foreach ($participants as $participant)
           <tr>   
                <td>{{ $loop->iteration }}</td>
                <td>{{ $participant->dni }}</td>
                <td>{{ $participant->name }} {{ $participant->firstlastname }} {{ $participant->secondlastname }}</td>
               <td>{{ $participant->position }}</td>
               <td>{{ $participant->superintendence }}</td>
               <td  class="text-center"><a href="{{ route('detail-participant', $participant->id) }}" class="btn btn-sm btn-success"><i class="fa fa-list-alt" aria-hidden="true"></i> Consolidado</a></td>
                <td width="10px"><a href="{{ route('edit_participant',Crypt::encryptString($participant->id)) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
            
          </tr>
          @endforeach  
        </tbody>              
      </table>      
    </div>           
  </div>       
</div>
</div>
</section> 
@endsection
