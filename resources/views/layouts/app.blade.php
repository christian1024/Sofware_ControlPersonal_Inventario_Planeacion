<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Darwin Colombia</title>

    <!-- Scripts -->
    <script src="{{ asset('Principal/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('Principal/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/Estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/myanimation.css') }}">

    <link rel="stylesheet" href="{{ asset('Principal/css/darwinperennialswebflow.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/webflow.css') }}">

    <link rel="stylesheet" href="{{ asset('Principal/css/custom.css') }}">

    <script src="{{ asset('Principal/js/modernizr.js') }}" defer></script>
    <script src="{{ asset('Principal/js/webflow.js') }}" defer></script>


    <!--new login -->
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('Ingreso/images/icons/favicon.ico') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/bootstrap/css/bootstrap.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/fonts/font-awesome-4.7.0/css/font-awesome.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/fonts/Linearicons-Free-v1.0.0/icon-font.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/fonts/iconic/css/material-design-iconic-font.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/animate/animate.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/css-hamburgers/hamburgers.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/animsition/css/animsition.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/select2/select2.min.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/vendor/daterangepicker/daterangepicker.cs') }}s">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/css/util.cs') }}s">
    <link rel="stylesheet" type="text/css" href="{{ asset('Ingreso/css/main.cs') }}s">

    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{  asset('Ingreso/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{  asset('Ingreso/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{  asset('Ingreso/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{   asset('Ingreso/js/main.js') }}"></script>
    <!--===============================================================================================-->
</head>
<body>
<div id="app">
    <main class="">
        @yield('content')
    </main>
</div>
</body>
</html>

