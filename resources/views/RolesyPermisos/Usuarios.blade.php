@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <div id="Usuarios" class="">
            <div class="col-lg-12">
                <div>
                    <h3> Usuarios Sistema</h3>
                </div>
                <div class="box box-primary col-lg-12">
                    <div class="box-body">
                        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#CreateUsuario">
                            <img src="{{ asset('img/add.png') }}">Nuevo Usuario
                        </button>
                    </div>
                    <hr>
                    <div>
                        <div id="Usuarios">
                            <div class="table-responsive" style="height: 100%">
                                <table id="UsuariosSistema" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Usuarios</th>
                                        <th>email</th>
                                        <th>Nombre Usuario</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach( $usuariostable as $usuariostables)
                                        <tr>
                                            <th>{{ $usuariostables->Primer_Nombre }} {{ $usuariostables->Primer_Apellido }}</th>
                                            <th>{{ $usuariostables->email }}</th>
                                            <th>{{ $usuariostables->username }}</th>
                                            <th style="position: center">
                                                <button onclick="PermisosUsuario('{{ encrypt($usuariostables->id) }}')" class="btn btn-success" style="position: center" title="Permisos"><i class="fa fa-lock"></i></button>
                                                <a class="btn btn-danger" title="Inactivar"><i class="fa fa-minus-circle"></i></a>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>

                </div>
                {{--@endcan--}}


            </div>
        </div>
    </div>

    <!--Modal Crear Usuario-->

    <div class="modal fade bigEntrance2" id="CreateUsuario" role="dialog">
        <div class="modal-dialog modal-lg " style="width: 80% !important; margin-top: 80px">
            <!-- Modal content-->
            <div class="modal-content ">
                <div class="modal-header" style="   text-align: center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title"><i class="fa fa-user-circle pulse" style="font-size: 40px; color: #0b97c4"></i> Crear Usuario</h3>

                </div>
                <form id="" class="form-control-file" method="POST" action="{{ route('CreateUsers') }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div>

                        <div class="col-md-12" style="margin-top: 20px">

                            <div class="form-group col-md-6">
                                <label for="id_Empleado" class="col-form-label text-md-right">{{ __('Usuario') }}</label>
                                <select id="id_Empleado" name="id_Empleado" class="selectpicker form-control labelform" data-live-search="true" required>
                                    <option selected="true" value="" disabled="disabled">Seleccione Usuario</option>
                                    @foreach($Empleados as $Empleados )
                                        <option value="{{ $Empleados ->id }}">
                                            {{$Empleados ->Primer_Apellido}}
                                            {{$Empleados ->Segundo_Apellido}}
                                            {{$Empleados ->Primer_Nombre}}
                                            {{$Empleados ->Segundo_Nombre}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control labelform{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>
                        <div class="col-md-12">

                            <div class="form-group col-md-6">
                                <label for="username" class="col-form-label text-md-right">{{ __('Usuario Sistema') }}</label>
                                <input id="username" type="text" class="form-control labelform{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group col-md-6">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control labelform{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                                          <strong>{{ $errors->first('password') }}</strong>
                                                                   </span>
                                @endif
                                <div id="ps1" class="invalid-feedback" role="alert">
                                    <span id="letter" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Al menos debería tener <strong>una letra.</strong></span><br>
                                    <span id="capital" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Al menos debería tener <strong>una letra en mayúsculas.</strong></span><br>
                                    <span id="number" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Al menos debería tener <strong>un número.</strong></span><br>
                                    <span id="length" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Debería tener <strong>8 carácteres</strong> como mínimo.</span><br>
                                    <span id="special" class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> Debería tener <strong>un carácteres</strong> como especial.</span><br>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer">

                        <div class="col-lg-10"></div>
                        <button type="submit" class="btn btn-primary" id="btnGuardar"> {{ __('Guardar') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        function PermisosUsuario($id) {
            window.location.href = '/Permisos/' + $id + '/empelados';
        }

        @if(session()->has('ok'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'success',
                position: 'center',
                message: 'Usuario creado Correctamente',
            });
            toastr["success"]("Usuario creado Correctamente");
            return true;
        });
        @endif
        @if(session()->has('error'))
        $(document).ready(function () {

            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Usuario Ya existente',
            });
            toastr["success"]("Usuario Ya existente");
            return true;
        });
        @endif


        $(document).ready(function () {
            $('#UsuariosSistema').DataTable({
                //aqui
                /*dom: '<"top"i>rt<"bottom"flp><"clear">',*/
                dom: "Bfrtip",
                paging: false,
                "language": {
                    "search": "Buscar:",
                    "info": "Registros Totales _TOTAL_",
                    "Previous": "Anterior",
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',

                    },
                ],
            });

        })
        $('#password').keyup(validate).focus(function () {
            $('#ps1').show();
        }).blur(function () {
            $('#ps1').hide();
        });

        $('#password-confirm').keyup(validate).focus(function () {
            $('#ps2').show();
        }).blur(function () {
            $('#ps2').hide();
        });

        // $('input[type=password]').keyup(validate).click(validate);
        function validate() {
            let pswd = $(this).val();
            let elm = 'ps2';
            if (this.id === 'password') {
                elm = 'ps1'
            }
            let error = 0;
            //validate the length
            if (pswd.length < 8) {
                error += 1;
                $('#' + elm + ' #length').removeClass('text-success').addClass('text-danger');
                $('#' + elm + ' #length i').removeClass('fa-check-square-o').addClass('fa-times');
            } else {
                $('#' + elm + ' #length').removeClass('text-danger').addClass('text-success');
                $('#' + elm + ' #length i').removeClass('fa-times').addClass('fa-check-square-o');
            }
            //validate letter
            if (pswd.match(/[A-z]/)) {
                $('#' + elm + ' #letter').removeClass('text-danger').addClass('text-success');
                $('#' + elm + ' #letter i').removeClass('fa-times').addClass('fa-check-square-o');
            } else {
                error += 1;
                $('#' + elm + ' #letter').removeClass('text-success').addClass('text-danger');
                $('#' + elm + ' #letter i').removeClass('fa-check-square-o').addClass('fa-times');
            }
            //validate capital letter
            if (pswd.match(/[A-Z]/)) {
                $('#' + elm + ' #capital').removeClass('text-danger').addClass('text-success');
                $('#' + elm + ' #capital i').removeClass('fa-times').addClass('fa-check-square-o');
            } else {
                error += 1;
                $('#' + elm + ' #capital').removeClass('text-success').addClass('text-danger');
                $('#' + elm + ' #capital i').removeClass('fa-check-square-o').addClass('fa-times');
            }

            //validate number
            if (pswd.match(/\d/)) {
                $('#' + elm + ' #number').removeClass('text-danger').addClass('text-success');
                $('#' + elm + ' #number i').removeClass('fa-times').addClass('fa-check-square-o');
            } else {
                error += 1;
                $('#' + elm + ' #number').removeClass('text-success').addClass('text-danger');
                $('#' + elm + ' #number i').removeClass('fa-check-square-o').addClass('fa-times');
            }

            //validate number
            if (pswd.match("[!,%,&,@,#,$,^,*,?,_,~]")) {
                $('#' + elm + ' #special').removeClass('text-danger').addClass('text-success');
                $('#' + elm + ' #special i').removeClass('fa-times').addClass('fa-check-square-o');
            } else {
                error += 1;
                $('#' + elm + ' #special').removeClass('text-success').addClass('text-danger');
                $('#' + elm + ' #special i').removeClass('fa-check-square-o').addClass('fa-times');
            }
            //console.log(error);
            if (error > 0) {
                $('#btnGuardar').attr('disabled', true);
            } else {
                $('#btnGuardar').attr('disabled', false);
            }
        }

    </script>
@endsection
