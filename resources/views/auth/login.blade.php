@extends('layouts.app')


@section('content')



    @if (Auth::guest())
        <div class="login">
            <h1 class="login__title">
                servicio de capacitación
            </h1>
            <form method="POST" action="{{ route('login') }}" class="login__form">
                {{ csrf_field() }}
                <img src="{{ asset('img/cover/raura.png') }}" alt="logo-raura" class="login__img">
                <img src="{{ asset('img/cover/minsur.png') }}" alt="logo-minsur" class="login__img">
                <h2 class="login__subtitle">ACESSO AL SISTEMA</h2> @if ($errors->has('email'))
                    <span class="login__error">{{ $errors->first('email') }}</span>
                @endif
                <input id="email" type="text"
                            class="form-control text-center @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                            required autocomplete="email" autofocus
                            placeholder="Ingrese su correo">
               <br>
                <input id="password" type="password" class="form-control text-center @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password"
                            placeholder="Ingrese su contraseña">
                <br>
                <button type="submit" class="btn login__submit">INGRESAR</button>
                <span class="login__description">¿Aun no cuentas con un usuario <a href="{{ url('/register') }}" class="login__register">Registrate AQUI</a></span>
            </form>
        </div>

    @else
        <div class="container">
            <div class="row">
                <div class="col-md-5" >
                    <div class="panel panel-default" class="well" id="login_init">
                        <div class="panel-body text-center">
                            <a href="{{route('home')}}" class="btn btn-success btn-block btn-lg">Continuar <i class="fa fa-angle-double-right" aria-hidden="true"></i></a><br>
                            <a href="{{ route('logout') }}" class="btn btn-link btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off" aria-hidden="true"></i> Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
<script>    
 // $('#modal-default').modal('show');
</script>
@endsection

