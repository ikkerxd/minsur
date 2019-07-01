@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">Registrar nuevo usuario</div>
                <div class="panel-body">
                    @if(session('message'))
                        <div class="alert alert-{{ session('message')[0] }} alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">Close</span>
                            </button>
                            <strong><i class="fa fa-ban" aria-hidden="true"> Alert!</i> {{ session('message')[1] }}</strong>
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o" aria-hidden="true"></i></span>
                                    <select id="unidad-select" name="unity" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($unities as $unity)
                                        <option value="{{$unity->id}}">{{ $unity->name }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                              
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-building-o" aria-hidden="true"></i></span>
                                    <select id="rs" name="rs" class="form-control select2" required>
                                        <option></option>
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}">{{ $company->businessName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{url('/registerCompany')}}" class="btn btn-danger" id="btn_add_company"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <hr> 
                        @php
                        $type_document = array(0 => 'DNI', 1 => 'Carnet de Extrangeria', 2 => 'Pasaporte');
                        @endphp
                        <p class="text-muted">DATOS PERSONALES</p>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('type_document') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-address-card-o" aria-hidden="true"></i></span>
                                           {!! Form::select('type_document', $type_document, null, ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-8">
                                <div class="form-group{{ $errors->has('dni') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-address-card-o" aria-hidden="true"></i></span>
                                            <input id="dni" type="text" class="form-control" name="dni" value="{{ old('dni') }}" required autofocus placeholder="Ingrese Doc. Identidad"/>
                                        </div>  
                                        @if ($errors->has('dni'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('dni') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Ingrese sus Nombres"/>
                                        </div>
                                        @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('firstlastname') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                            <input id="firstlastname" type="text" class="form-control" name="firstlastname" required placeholder="Ingrese Ap. paterno" value="{{ old('firstlastname') }}"/>
                                        </div> 
                                        @if ($errors->has('firstlastname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('firstlastname') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div> 
                            </div>

                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('secondlastname') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                            <input id="secondlastname" type="text" class="form-control" name="secondlastname" required placeholder="Ingrese Ap. materno" value="{{ old('secondlastname') }}"/>
                                        </div> 
                                        @if ($errors->has('secondlastname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('secondlastname') }}</strong>
                                        </span>
                                        @endif 
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted">CREDENCIALES PARA ACCESO AL SISTEMA</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                       <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Ingrese su correo"/>
                                    </div>
                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                </div>
                            </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                       <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        <input id="password" type="password" class="form-control" name="password" value="{{ old('email') }}" required autofocus placeholder="Ingrese su clave"/>
                                    </div>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                       <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ old('email') }}" required autofocus placeholder="Nuevamente su clave"/>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        </div>


                        <p class="text-muted">DATOS DE VALORIZACION</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('email_valorization') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope-square" aria-hidden="true"></i></span>
                                            <input id="email_valorization" type="email" class="form-control" name="email_valorization" value="{{ old('email_valorization') }}" required autofocus placeholder="Ingrese el email para la valorizaion"/>
                                        </div>
                                        @if ($errors->has('email_valoracion'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                            <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}" required autofocus placeholder="Ingrese telefono"/>
                                        </div>
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">                           
                            <div class="col-md-4">
                                <div class="input-group">
                                    {!! Form::select('type_document', $type_document, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input id="dni" type="text" class="form-control" name="dni" value="{{ old('name') }}" required autofocus placeholder="Documento Identidad"/>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input id="phone" type="text" class="form-control" name="phone" value="{{ old('name') }}" required autofocus placeholder="Nro Celular"/>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>  


                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">                           
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Nombre completo"/>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input id="firstlastname" type="text" class="form-control" name="firstlastname" value="{{ old('name') }}" required autofocus placeholder="Ap. paterno"/>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input id="secondlastname" type="text" class="form-control" name="secondlastname" value="{{ old('name') }}" required autofocus placeholder="Ap. Materno"/>
                                </div>

                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted">CREDENCIALES PARA ACCESO AL SISTEMA</p>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Ingrese su correo electronico"/>
                                </div>

                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus placeholder="Ingrese su contraseña"/>
                                </div>

                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Ingrese su contraseña nuevamente"/>
                                </div>                              
                            </div>
                        </div>
                        <hr> --}}
                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary pull-right load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Registrando ...">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Registrar
                                </button>                                
                                <a href="{{route('login')}}" class="btn btn-link pull-right">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <p class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Si no encuentra su empresa, clic en boton rojo para registrarlo</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script>
    $('.select2').select2({
      placeholder: "Seleccione su empresa...",
      allowClear: true
    });

    $('#unidad-select').select2({
        placeholder: "Seleccione su Unidad minera...",
        allowClear: true
    });
    $('.load').on('click', function() {
        var $this = $(this);
        if($('#password-confirm').val() != "" && $('#rs option:selected').text() != "")       
        {
            $this.button('loading');
        }else{
            $this.button('reset');
        }     
    });
</script>
@endsection
