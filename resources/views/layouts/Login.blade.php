@extends('layouts.app')

@section('content')

    <body style="background-color: #999999;">

    <div class="limiter">
        <div class="container-login100">
            <div class="login100-more" style="background-image: url('Ingreso/images/fondo.jpg');">
               <div class="container text-center h-100 d-flex justify-content-center align-items-center">
                   <div class="centrado">DARWIN COLOMBIA SAS</div>
               </div>
            </div>

            <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
					<span class="login100-form-title p-b-59">
						Darwin Colombia
					</span>

                    <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <span class="label-input100">Usuario</span>
                        <input id="login" type="login" class="input100 login-input form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" autocomplete="off" name="login" value="{{ old("login") }}" required autofocus placeholder='Usuario'>
                        <span class="focus-input100"></span>
                        @if ($errors->has('login'))
                            <span class='help-block' STYLE="text-align: center">
                                 <strong>{{ $errors->first('login') }}</strong>
                                 </span>
                        @endif
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Contraseña</span>
                        <input id="password" type="password" placeholder="Contraseña" class="input100 login-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                        <span class="focus-input100"></span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div class="container-login100-form-btn form-group text-center">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn btn-lg btn-block">
                                Iniciar Sesión
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


    </body>
@endsection
