<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Darwin Colombia</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

{{--<link rel="stylesheet" href="{{ asset('plantilla/sweetalert/dist/sweetalert.css') }}">--}}

<!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('Principal/css/all.min.css') }} ">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('Principal/css/ionicons.min.css') }} ">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href=" {{ asset('Principal/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href=" {{ asset('Principal/css/icheck-bootstrap.min.css') }} ">
    <!-- JQVMap -->
    <link rel="stylesheet" href=" {{ asset('Principal/css/jqvmap.min.css') }} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('Principal/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('Principal/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('Principal/css/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('Principal/css/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="{{ asset('Principal/css/css.css')}}">
    <link rel="stylesheet" href="{{ asset('Principal/css/bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Principal/css/pivot.css') }}">
    {{--data table--}}
    <link rel="stylesheet" href="{{ asset('Principal/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/Estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('Principal/css/iziToast.css') }}">

    {{--<link href=" {{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">--}}

<!-- jQuery -->
    <script src="{{asset('Principal/js/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('Principal/js/jquery-ui.min.js')}}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('Principal/js/bootstrap.bundle.min.js')}}"></script>
    <!-- ChartJS -->
    <script src="{{asset('Principal/js/Chart.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('Principal/js/sparkline.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{asset('Principal/js/jquery.knob.min.js')}}"></script>
    <!-- daterangepicker -->
    <script src="{{asset('Principal/js/moment.min.js')}}"></script>
    <script src="{{asset('Principal/js/daterangepicker.js')}}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('Principal/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <!-- Summernote -->
    <script src="{{asset('Principal/js/summernote-bs4.min.js')}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('Principal/js/jquery.overlayScrollbars.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('Principal/js/adminlte.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{asset('Principal/js/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('Principal/js/demo.js')}}"></script>
    {{--data table--}}
    <script src="{{ asset('Principal/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('Principal/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Principal/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('Principal/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('Principal/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('Principal/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('Principal/js/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('Principal/js/iziToast.js')}}"></script>
    <script src="{{ asset('Principal/js/pivot.js') }}"></script>
    <script src="{{ asset('Principal/js/pivot.es.js') }}"></script>
    <script src="{{ asset('Principal/js/datatables.min.js') }}"></script>

    <script src="{{ asset('Principal/js/plotly-basic-latest.min.js') }}"></script>
    <script src="{{ asset('Principal/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="{{ asset('Principal/js/plotly_renderers.js') }}"></script>


    {{--<script src="{{ asset('js/bootstrap-select.js') }}"></script>--}}

    {{--<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/datatables.min.js"></script>
--}}

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            {{-- <li class="nav-item d-none d-sm-inline-block">
                 <a href="index3.html" class="nav-link">Homee</a>
             </li>
             <li class="nav-item d-none d-sm-inline-block">
                 <a href="#" class="nav-link">Contact</a>
             </li>--}}
        </ul>

        <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3">
         <div class="input-group input-group-sm">
             <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
             <div class="input-group-append">
                 <button class="btn btn-navbar" type="submit">
                     <i class="fas fa-search"></i>
                 </button>
             </div>
         </div>
     </form>--}}

    <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
            @can('BotonAlertasNotificaciones')
                <li>
                    <a class="nav-link" href="{{ route("ProgramasInvernaderoPendientes") }}">
                        <i class="fab fa-pagelines"></i>
                        <span class="badge badge-danger navbar-badge">{{ session()->get('user')['countInv']}}</span>
                    </a>
                </li>
            @endcan

            @can('BotonNotificacionProgramas')
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route("ProgramasEjecutados") }}">
                        <i class="fas fa-flag"></i>
                        <span class="badge badge-danger navbar-badge"></span>
                    </a>
                </li>
            @endcan

            @can('BotonAlertasNotificaciones')
                <li class="nav-item dropdown">
                    <a class="nav-link" href="{{ route("ProgramasPendientes") }}">
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-danger navbar-badge">{{ session()->get('user')['count']}}</span>
                    </a>
                </li>
            @endcan
        <!-- Notifications Dropdown Menu -->


            {{-- <li class="nav-item">
                 <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                     <i class="fas fa-user-circle">{{ session()->get('user')['nameLogin']}}</i>
                 </a>
             </li>--}}
        </ul>
        <ul class="navbar-nav navbar-right">

            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    {{--<img alt="image" src="{{ asset('Plantilla\img\avatar\avatar-1.png') }}" class="rounded-circle mr-1">--}}
                    <div class="d-sm-none d-lg-inline-block"><i class="fas fa-user-circle">
                        </i> <span class="caret"></span></div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item has-icon text-danger" href="{{ route('Welcome') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a class="brand-link">
            {{--<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">--}}

            <span class="brand-text font-weight-light">Darwin Colombia</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    @if(session()->get('user')['img'] === null)
                        <img src="{{ asset('imagenes/Noimg.png') }} " alt="User Image" class="brand-image img-circle elevation-3"
                             style="opacity: .8">

                    @else
                        <img src="{{ asset('imagenes/'.session()->get('user')['img']) }} " class="brand-image img-circle elevation-3"
                             style="opacity: .8">
                    @endif
                </div>
                <div class="info">
                    <i class="fa fa-circle text-success fa fa-bars fa-xs"></i>
                    <a>{{ session()->get('user')['nameLogin']}}</a>
                    {{-- <a class="d-block">{{ session()->get('user')['nameLogin']}} </a>--}}
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    {{--Menu Gestion Humana--}}
                    @can('menuRRHH')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    {{ __('Gestion Humana') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('VistaEmpleados')
                                    <li class="nav-item">
                                        <a href="{{ route("EmpleadossubMenu") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Listar Empleados') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                                @can('Vistausuarios')
                                    <li class="nav-item">
                                        <a href="{{ route("UsariossubMenu") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Usuarios Sistema') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                            </ul>
                        </li>
                    @endcan

                    @can('menuPortafolio')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>
                                    {{ __('Portafolio') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('Vistavariedades')
                                    <li class="nav-item">
                                        <a href="{{ route("VariedadessubMenu") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Variedades') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                                @can('InformacionTecnica')
                                    <li class="nav-item">
                                        <a href="{{ route("InformacionTecnicaurc") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Informacion Tecnica') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                                @can('FichaTecnicaGenerosPruebas')
                                    <li class="nav-item">
                                        <a href="{{ route("viewFichaTecnicaGenerospruebas") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Ficha Tecnica Generos') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                            </ul>
                        </li>
                    @endcan

                    @can('menuLaboratorio')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-flask"></i>
                                <p>
                                    {{ __('Laboratorio') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('subMenuParametrizacion')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-cogs"></i>
                                            <p>
                                                {{ __('Parametrización') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('MenuTablasMaestras')
                                                <li class="nav-item">
                                                    <a href="{{ route("TablasMaestras") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Tablas Maestras') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistadistribucionCuartos')
                                                <li class="nav-item">
                                                    <a href="{{ route("viewAdminCuartos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Distribución Cuartos') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistainfoTecnica')
                                                <li class="nav-item">
                                                    <a href="{{ route("viewInfoTecnica") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Informacón Tecnica') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuInventario')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-folder"></i>
                                            <p>
                                                {{ __('Movimientos Inventario') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            @can('VistaActivarSalidas')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaReactivarProgramas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Activar Salidas') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaAjsuteInv')
                                                <li class="nav-item">
                                                    <a href="{{ route("AjusteInventario") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Ajuste Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLecturaArqueo')
                                                <li class="nav-item">
                                                    <a href="{{ route("ArqueoInventario") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Arqueo Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaMigrarEtq')
                                                <li class="nav-item">
                                                    <a href="{{ route("CambioEtiqueta") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Cambio Etiqueta') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaCarguerInventario')
                                                <li class="nav-item">
                                                    <a href="{{ route("viewloadinventory") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Cargue Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLecturaEntrada')
                                                <li class="nav-item">
                                                    <a href="{{ route("LecturaEntrada") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Entrada') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLecturaSalida')
                                                <li class="nav-item">
                                                    <a href="{{ route("LecturaSalida") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Salida') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLecturaSalida')
                                                <li class="nav-item">
                                                    <a href="{{ route("LecturaDespunte") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Despunte') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaUbicacionVari')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaUbicacionVariedades") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Ubicacion Variedad') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuReportes')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                {{ __('Reportes') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('vistaReporteinv')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReportesLaboratorio") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reporte Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuControlFases')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-bookmark"></i>
                                            <p>
                                                {{ __('Control Fases') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('vistaMovimientoFase')
                                                <li class="nav-item">
                                                    <a href="{{ route("MovimientoFasesLabChr") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Movimiento Fase') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuGenerarETQ')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-barcode"></i>
                                            <p>
                                                {{ __('Generar Etiquetas') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('vistaGenerarEtiquetas')
                                                <li class="nav-item">
                                                    <a href="{{ route("GenerarEtiquetasCargue") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Etiquetas Cargue') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('Consulta')
                                                <li class="nav-item">
                                                    <a href="{{ route("ConsultarEtiquetas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Consultar Etiquetas') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('vistaProgramasImports')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-tasks"></i>
                                            <p>
                                                {{ __('Programas Semalaes') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ route("vistaProgramasImports") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Ejecución Programas') }}</p>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                @endcan()
                            </ul>
                        </li>
                    @endcan

                    @can('menuVentas')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    {{ __('Ventas') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('subMenuPedidos')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-shopping-cart"></i>
                                            <p>
                                                {{ __('Pedidos') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('VerVistaOrdenesPedido')
                                                <li class="nav-item">
                                                    <a href="{{ route("OrdenesPedidos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Orden de Pedido') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuSimulador')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-play"></i>
                                            <p>
                                                {{ __('Simulador') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SimuladorView')
                                                <li class="nav-item">
                                                    <a href="{{ route("SimuladorView") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Simular Planeacion') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuReportePedidos')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-book"></i>
                                            <p>
                                                {{ __('Reportes Pedidos') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('ReporteConfirmacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReporteConfirmacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reporte Confirmacion') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('ReporteGeneralPedidos')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReporteGeneralPedidos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reporte General Pedidos') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('ReportePlaneacionPedidos')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReportePlaneacionPedidos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reporte Planeacion Pedidos') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('subMenuEjecucionesLaboratorio')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-sitemap"></i>
                                            <p>
                                                {{ __('Reportes Ejecuciones') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubsubmenuReporteEjecuciones')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReporteEjecucionesSemanales") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Ejecuciones Semanales') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                        </ul>
                                    </li>
                                @endcan()

                            </ul>
                        </li>
                    @endcan

                    @can('menuCompras')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-podcast"></i>
                                <p>
                                    {{ __('Compras') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('VistaIntroducciones')
                                    <li class="nav-item">
                                        <a href="{{ route("Introduccion") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Nueva Introducción') }}</p>
                                        </a>
                                    </li>
                                @endcan()

                                @can('VistaIntroduccionesFuturas')
                                    <li class="nav-item">
                                        <a href="{{ route("IntroduciconesFuturasView") }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>{{ __('Introducciones Futuras') }}</p>
                                        </a>
                                    </li>
                                @endcan()
                            </ul>
                        </li>
                    @endcan

                    @can('MenuInvernadero')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-leaf"></i>
                                <p>
                                    {{ __('Invernadero') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('SubMenuMovimintosInvernadero')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-folder"></i>
                                            <p>
                                                {{ __('Movimiento de Inventario') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('VistaLectEntradaInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaEntradaInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Entrada') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectTrasladoInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaTrasladoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Traslado') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()


                                            @can('VistaLectDescarteInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaTrasladoInternoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Traslado inter') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectDescarteInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaDescarteInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Descarte') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectTrasladoInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaDespachoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Despacho') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectTrasladoInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaAlistamientoDespachoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Alistamiento') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLectTrasladoInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaSalidaAlistamientoDespachoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Salida Alistamiento') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectDescarteInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaSalidaCancelacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Cancelación') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLectDescarteInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaConsultaCodigoInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Consultar Codigo') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                        </ul>
                                    </li>
                                @endcan()

                                @can('MenuReportesInvernadero')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-map"></i>
                                            <p>
                                                {{ __('Reportes de Inventario') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubMenuReportesInvernadero')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaReportesInvernadero") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reportes Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                                @can('MenuServicioAdaptacion')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fab fa-pagelines"></i>
                                            <p>
                                                {{ __('Servicio Adaptación') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubMenuServicioAdaptacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("Servicioadaptacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Entrada Adaptación') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                        </ul>
                                    </li>
                                @endcan()

                            </ul>
                        </li>
                    @endcan

                    @can('MenuPropagacion')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-leaf"></i>
                                <p>
                                    {{ __('Propagación') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                @can('SubMenuTablasMaestrasPropagacion')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-table"></i>
                                            <p>
                                                {{ __('Tablas Mestras') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('VistaTablasMaestrasPropagacionPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaTablasMaestrasPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Tablas Mestras') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                        </ul>
                                    </li>
                                @endcan()

                                @can('SubMenuMovimintosPropagacion')
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-shopping-cart"></i>
                                            <p>
                                                {{ __('Movimientos Inventario') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('VistaLectEntradaPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaEntradaPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Entrada') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLectTrasladoPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaTraladoPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura traslado') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaLectDescartePropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaDescartePropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Descarte') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectSalidaPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaSalidaPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Salida') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaLectArqueoPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaArqueoPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lectura Arqueo') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()


                                            @can('ViewConfirmacionesPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("ViewConfirmacionesPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Confirmaciones') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()


                                            @can('VistaEtiquetasPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("CargueInventarioRenewalProduccion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Etiquetas Renewall') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('VistaUpdateEtiqueta')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaUpdateEtiqueta") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Modificar Etiqueta') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('CancelacionRenewall')
                                                <li class="nav-item">
                                                    <a href="{{ route("CancelacionRenewall") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Cancelación Renewall') }}</p>
                                                    </a>
                                                </li>
                                            @endcan

                                            @can('VistaProgramasSemanales')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaProgramasSemanalesRenewall") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Programas Confimados') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('subsubmenuEntregasNovedades')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaEntregasNovedadesRenewall") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Entrega Novedades') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()


                                        </ul>
                                    </li>
                                @endcan()

                                @can('SubMenuReportesPropagacion')
                                    <li class="nav-item has-treeview">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-shopping-cart"></i>
                                            <p>
                                                {{ __('Reportes Inventario') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('VistaReportesPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaReportePropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Reporte Inventario') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()
                                            @can('VistaEspacioPropagacion')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaEspacioPropagacion") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Espacio Propagación') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                            @can('EstadoPlotEntrega')
                                                <li class="nav-item">
                                                    <a href="{{ route("Estadoplotidentrega") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Estado plotID') }}</p>
                                                    </a>
                                                </li>
                                            @endcan()

                                        </ul>
                                    </li>
                                @endcan()

                            </ul>
                        </li>
                    @endcan

                    @can('menuProduccion')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p>
                                    Produccion
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                @can('SubmenuControlSiembras')
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-check-circle"></i>
                                            <p>
                                                Control Siembras
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubSubmenuReporteSiembrasConfirmadasurc')
                                                <li class="nav-item">
                                                    <a href="{{ route("ReporteSiembrasConfirmadas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Siembras Pre-Confirmadas</p>
                                                    </a>
                                                </li>
                                            @endcan




                                            @can('SubSubmenuCargueSiembrasConfirmadasurc')
                                                <li class="nav-item">
                                                    <a href="{{ route("Viewcarguesiembrasurc") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Siembras Confirmadas</p>
                                                    </a>
                                                </li>
                                            @endcan

                                            @can('SubSubmenuReportesSiembrasynovedades')
                                                <li class="nav-item">
                                                    <a href="{{ route("ViewSiembrasProximasEntregas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Reportes Siembras</p>
                                                    </a>
                                                </li>
                                            @endcan

                                            {{--pendiente--}}
                                            @can('SubSubmenuReportesSiembrasCampoApp')
                                                <li class="nav-item">
                                                    <a href="{{ route("ViewSiembrasProximasEntregas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Reportes Siembras App</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            {{-- hasta aqui sigue pendiente--}}
                                        </ul>
                                    </li>
                                @endcan()



                                @can('SubmenuDespachosProd')
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-briefcase"></i>
                                            <p>
                                                Despachos
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubSubmenuLecturaEntradaProd')
                                                <li class="nav-item">
                                                    <a href="{{ url("/LecturaEntradaProduccionView") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Lectura Entrada</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('SubSubmenuLecturaSalidaRenewalProd')
                                                <li class="nav-item">
                                                    <a href="{{ url("/LecturaSalidaRenewalProduccionView") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Lectura Salida </p>
                                                    </a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan()
                                @can('SubmenuReportesProd')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-print"></i>
                                            <p>
                                                Reportes
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubSubmenuReporteEstadoCajaRenewalProd')
                                                <li class="nav-item">
                                                    <a href="{{ url("/VistaEstadoCajasRenewal") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Estado Cajas Renewal</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan()

                                {{--plan B--}}
                                @can('SubmenuPlanB')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="nav-icon fas fa-street-view"></i>
                                            <p>
                                                Control Cuarto Frio
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('SubSubmenuCarguePlanB')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaCargueEtiquetas") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Cargue Etiquetas</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('SubSubmenuLecturaEntradaPlanB')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaEntradaCuarto") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Lectura entrada</p>
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('SubSubmenuLecturasalidaPlanB')
                                                <li class="nav-item">
                                                    <a href="{{ route("VistaLecturaSalidaCuarto") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>Lectura Salida</p>
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcan()

                            </ul>
                        </li>
                    @endcan

                    @can('menuSistemas')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-desktop"></i>
                                <p>
                                    IT
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('submenusoporte')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-cog"></i>
                                            <p>
                                                Solicitud Soporte
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ route("ViewTickes") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Lista Tickest</p>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan

                    @can('menuFitopatologia')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-flask"></i>
                                <p>
                                    {{ __('Fitopatologia') }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('submenuReporteVirus')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-bug"></i>
                                            <p>{{ __('Virus') }}</p>
                                            <i class="right fas fa-angle-left"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('subsubmenuReporteVirus')
                                                <li class="nav-item">
                                                    <a href="{{ route("ViewVirusFitopatogenos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Lista Virus') }}</p>
                                                    </a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan
                                {{--muestras--}}
                                @can('submenumuestras')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-search"></i>
                                            <p>{{ __('Analisis Muestras') }}</p>
                                            <i class="right fas fa-angle-left"></i>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            @can('subsubmenumuestraslaboratorio')
                                                <li class="nav-item">
                                                    <a href="{{ route("viewmuestraslaboratorio") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Analisis Laboratorio') }}</p>
                                                    </a>
                                                </li>
                                            @endcan

                                            @can('subsubmenuReporteVirus')
                                                <li class="nav-item">
                                                    <a href="{{ route("ViewVirusFitopatogenos") }}" class="nav-link">
                                                        <i class="far fa-circle nav-icon"></i>
                                                        <p>{{ __('Analisis Urc') }}</p>
                                                    </a>
                                                </li>
                                            @endcan

                                        </ul>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endcan

                    @can('menuMonitoreo')
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-search"></i>
                                <p>
                                    {{ __('Monitoreo') }}
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('submenumovimientosMonitoreo')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-cog"></i>
                                            <p>
                                                {{ __('Control Monitoreo') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ route("ViewLecturaEntradaCuarto") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Lectrura Entrada Cuarto') }}</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ route("ViewLecturaEntradaCuartoOperario") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Lectrura Inicio Operacion') }}</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ route("ViewLecturaFinCuartoOperario") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Lectrura Fin Operacion') }}</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ route("ViewLecturaInicioMonitoreo") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Lectrura Entrada Moni') }}</p>
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="{{ route("ViewLecturaSalidaMonitoreo") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Lectrura Salida Moni') }}</p>
                                                </a>
                                            </li>


                                        </ul>
                                    </li>
                                @endcan

                                @can('submenuReportesMonitoreo')
                                    <li class="nav-item has-treeview ">
                                        <a href="#" class="nav-link">
                                            <i class="fa fa-book"></i>
                                            <p>
                                                {{ __('Reportes Monitoreo') }}
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ route("VistaReportesMonitoreos") }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>{{ __('Reportes') }}</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                    @endcan


                </ul>

                @can('NuevoSoporte')
                    <footer>
                        <div class="text-center">
                            <a href="" style=" text-decoration-line: underline;  text-decoration-color: #148ea1; color: #148ea1" data-toggle="modal" data-target="#creartickest">
                                Solicitud Soporte
                            </a>
                        </div>
                    </footer>
                @endcan

            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('contenidoPrincipal')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar">
        <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
                @if(session()->has('img'))
                    <img src="{{ asset('imagenes/'.session()->get('user')['img']) }} " class="img-circle" alt="User Image">
                @else
                    <img src="{{ asset('imagenes/Noimg.png') }} " class="img-circle" alt="User Image">
                @endif

                <p>
                    {{ session()->get('user')['nameLogin']}}
                </p>
            </li>
            <!-- Menu Body -->

            <!-- Menu Footer-->
            <li class="user-footer">
                <div class="pull-left">
                    <a href="#" class="btn btn-default btn-flat btn-xs">Cambiar Contraseña</a>
                </div>
                <div class="pull-right">
                    <a class="btn btn-default btn-flat btn-xs" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">{{ __('Cerrar sesion') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </aside>

    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script>

</script>

</body>
</html>
@include('Modal.nuevotickets')
