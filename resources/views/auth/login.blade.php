@extends('layouts.app')

@section('content')
    <body class="body-img" >
    <div class="row justify-content-center">
        <div class="col-lg-12 col-xs-12 col-md-12" style="text-align: center; margin-top: 50px">
            <img src="{{ asset('Principal/img/darwincolombia.png') }}"/>
        </div>

        <div class="col-md-4">
            <div style="text-align: center;">
                <img src="{{ asset('Principal/img/icono.png')}}"/>
            </div>
            <div class="logi-inter fadeIn">

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div style="margin-top: 30px">
                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2 col-xs-2"></div>

                            <div class="col-md-8 col-xs-8 col-lg-8">
                                <input  style="text-align: center" id="login" type="login" class="login-input form-control{{ $errors->has('login') ? ' is-invalid' : '' }}" autocomplete="off" name="login" value="{{ old("login") }}" required autofocus placeholder='Usuario'>

                                @if ($errors->has('login'))
                                    <span class='help-block' STYLE="text-align: center">
                                 <strong>{{ $errors->first('login') }}</strong>
                                 </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-2 col-lg-2 col-xs-2"></div>

                        <div class="form-group row">
                            <div class="col-md-2 col-lg-2 col-xs-2"></div>
                            <div class="col-md-8 col-xs-8 col-lg-8">
                                <input style="text-align: center" id="password" type="password" placeholder="Contraseña" class="login-input form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2 col-lg-2 col-xs-2"></div>
                        </div>

                        <div class="form-group row" style="text-align: center">
                            <div class="col-md-2 col-lg-2 col-xs-2"></div>
                            <div class="col-md-8 col-xs-8 col-lg-8">


                                <div class="form-group row" style="text-align: center">
                                    <div class="col-md-2 col-lg-2 col-xs-2"></div>
                                    <div class="col-md-8 col-xs-8 col-lg-8">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            {{ __('Iniciar Sesión') }}
                                        </button>
                                        </br>
                                        {{--<a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>--}}
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-xs-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    </body>
@endsection
