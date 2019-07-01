
@extends('layouts.templates')

@section('content')

<section class="content-header">
  <h1>
    <i class="fa fa-check-circle-o"></i> Validar Participante
    <small>Version 1.0</small>
  </h1>
  
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    @role('admin')
    <li><a href="#">Configuracion</a></li>
    @endrole
    <li class="active">Validar participante</li>
  </ol>
  
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">    
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">              
              <form id="search_user_validate" class="form-inline">
              {{ csrf_field() }}
                <div class="form-group">                  
                  <input type="text" class="form-control text-center" name="dni_ce" id="dni_ce" placeholder="Ingrese Doc Identidad">
                </div>
                <button type="submit" class="btn btn-info"><i class="fa fa-search" aria-hidden="true"></i></button>
              </form>        
          </div>
        </div>
        <hr>
        <span id="tbody_his_dni"></span>
        <!-- <div class="row">            
                          <div class="col-md-12">           
                            <table class="table table-bordered table-hover text-center">
                              <thead>
                                <tr>     
                                    <th>DNI</th>
                                    <th>PARTICIPANTE</th>
                                    <th>EMPRESA</th>
                                    <th>PACK</th>
                                    <th>VER</th>
                                    
                                </tr>
                              </thead>
                              <tbody class="tbody_his_dni">           
                              </tbody>              
                            </table> 
                          </div>                 
                        </div>  -->                
      </div>
    </div> 
  </div>
</div>
</section>
@endsection
