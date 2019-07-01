@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Registrar Empresa</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('register_company_user') }}">
                        {{ csrf_field() }}                                           
                        <div class="form-group">                           
                            <div class="row">
                                <div class="col-md-5 col-md-offset-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-address-card" aria-hidden="true"></i></span>
                                    <input id="ruc" type="text" class="form-control" name="ruc" required placeholder="Ingrese su RUC"/>
                                </div>                               
                            </div>
                            <div class="col-md-5">
                                <span id="result_company"></span>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building" aria-hidden="true"></i></span>
                                    <input id="businessName" type="text" class="form-control" name="businessName" required placeholder="Ingrese su Razón Social"/>
                                </div>                                
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                                    <input id="address" type="text" class="form-control" name="address" required placeholder="Ingrese su dirección"/>
                                </div>                                
                            </div>
                            </div>
                        </div>                       
                        <div class="form-group text-center">
                            <div class="row">
                                <div class="col-md-10">                                
                                <button type="submit" id="btn_add_company" class="btn btn-primary pull-right load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Registrando ...">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar
                                </button>
                                <a href="{{route('register')}}" class="btn btn-link pull-right">Cancelar</a>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>   

    $('.load').on('click', function() {        
        if($('#businessName').val() != "" && $('#address').val() != "")       
        {
            $('.load').button('loading');
        }else{
            $('.load').button('reset');
        }     
    });
</script>
@endsection