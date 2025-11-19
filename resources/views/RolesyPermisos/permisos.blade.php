@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">Título del panel con estilo normal</div>
                <div class="panel-body col-12">
                    <div class="col-12">
                        <label>{{ __('Empleado') }}</label>
                        <input disabled value="{{ $datosUsuario->Primer_Nombre }} {{ $datosUsuario->Primer_Apellido }}">

                        <label>{{ __('Usuario') }}</label>
                        <input disabled value="{{ $datosUsuario->username }} ">

                        <label>{{ __('Contraseña') }}</label>
                        <input disabled type="password" value="*************************">
                    </div>
                    <hr>

                    <div class="col-12">
                        <table id="Tablapermisos" class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre Permiso</th>
                                <th scope="col">Permiso</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php( $count =1)
                            @foreach( $permisos as $permiso)
                                <tr>
                                    <td>{{ $count }}</td>
                                    <th>{{ $permiso->name }}</th>
                                    <th><input type="checkbox" value="{{ $permiso->id }}"></th>
                                </tr>
                                @php($count++)
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="col-12">
                         <div class="col-lg-3">
                             <div class="panel panel-primary">
                                 <div class="panel-heading">Menus</div>
                                 <div>
                                     <ol style="margin-left:-20px">
                                         <li><input type="checkbox" name="GestionHumana"><b> {{ __('Gestion Humana') }}</b>
                                             <ol>
                                                 <li><input type="checkbox"> {{ __('Listar Empleados') }}</li>
                                                 <li><input type="checkbox"> {{ __('Usuarios Sistema') }}</li>
                                             </ol>
                                         </li>
                                         <li><input type="checkbox" name="GestionHumana"> <b>{{ __('Portafolio') }}</b>
                                             <ol>
                                                 <li><input type="checkbox"> {{ __('Variedades') }}</li>
                                             </ol>
                                         </li>

                                         <li><input type="checkbox" name="GestionHumana"> <b> {{ __('Laboratorio') }}</b>
                                             <ol>
                                                 <li><input type="checkbox" name="GestionHumana"><b> {{ __('Parametrizacion') }}</b>
                                                     <ul>
                                                         <li><input type="checkbox" name="GestionHumana"> {{ __('Tablas Maestras') }}</li>
                                                         <li><input type="checkbox" name="GestionHumana"> {{ __('Distribucion Cuartos') }}</li>
                                                         <li><input type="checkbox" name="GestionHumana"> {{ __('Informacion Tecnica') }}</li>

                                                     </ul>
                                                 </li>
                                             </ol>
                                         </li>
                                     </ol>
                                 </div>
                                 <button class="btn btn-success btn-block"> Cargar </button>
                             </div>

                         </div>

                         <div class="col-lg-9">
                             <div class="panel panel-primary">
                                 <div class="panel-heading">Permisos Detallados</div>
                                 <div class="panel-body col-12">

                                     <table class="table table-bordered">
                                         <thead class="thead-dark">
                                         <tr>
                                             <th scope="col">#</th>
                                             <th scope="col">Accion</th>
                                             <th scope="col">permiso</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         <tr>
                                             <th scope="row">1</th>
                                             <th>Crear empleado</th>
                                             <th><select>
                                                     <option>Permitido</option>
                                                     <option>Negado</option>
                                                 </select></th>

                                         </tr>
                                         <tr>
                                             <th scope="row">2</th>
                                             <th>Modificar empleado</th>
                                             <th><select>
                                                     <option>Permitido</option>
                                                     <option>Negado</option>
                                                 </select></th>

                                         </tr>

                                         </tbody>
                                     </table>

                                 </div>
                             </div>
                         </div>
                     </div>--}}
                </div>
            </div>
        </div>
    </div>

    <script>

        $('#Tablapermisos').DataTable({
            dom: "Bfrtip",
            paging: true,
            "language": {
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_,  _TOTAL_ Registros",
                "Previous": "Anterior",
            },

            buttons: [
                {
                    extend: 'excelHtml5',
                    text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                    titleAttr: 'Excel',
                },

            ],
        })


    </script>
@endsection
