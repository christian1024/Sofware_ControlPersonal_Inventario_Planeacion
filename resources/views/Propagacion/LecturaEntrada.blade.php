@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura entrada</h3>
        </div>
        <form id="LecturaEntradaPropagacion" method="get" action="{{ route('VistaLecturaEntradaPropagacion') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="card-body col-lg-12">

                <div class="form-row">

                    <div class="col-lg-4 ">
                        <label>Ubicacion</label>
                        <select class="labelform form-control" required id="idUbicacion" name="idUbicacion">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}"> {{ $ubicacion->Ubicacion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 ">
                        <label>Operario siembra</label>
                        <input type="number" maxlength="4" minlength="3" class="labelform form-control" autocomplete="off" id="Operario" required name="Operario">

                    </div>

                    <div class="col-lg-4 ">
                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="CodigoBarras" required name="CodigoBarras">
                    </div>
                </div>


                <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR DE CODIGO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>CODIGO YA FUE LEIDO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="OperarioEror" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>OPERARIO NO EXISTE</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="errorCuartoFrio" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>SIN SALIDA CUARTO FRIO</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="erroEspacio" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>SIN ESPACIO SUFICIENTE</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center">
            <div style="display: flex; justify-content:center; align-items: center;">
                <h4>Ultima Lectura</h4>
            </div>
            <hr>
            <div class="form-row">

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Variedad</label></i>
                        <input id="Variedad" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> PlotId</label></i>
                        <input id="PLotid" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Cantidad Bandejas</label></i>
                        <input id="CantBan" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Cantidad Plantas</label></i>
                        <input id="CantPL" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Total Bandejas Banco</label></i>
                        <input id="TotalBandBan" class="labelform form-group" disabled>
                    </div>
                </div>

            </div>

            {{-- <span id="count"></span>--}}
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>


        </div>


    </div>

    <script>

        $(document).ready(function () {
            $('#LecturaEntradaPropagacion').submit(function (event) {
                event.preventDefault();
                let DatosEviados = $('#LecturaEntradaPropagacion').serialize();//paso todos los datos del for a una variable
                let barcode = $('#CodigoBarras').val();//asigno input a una variable para validar
                let token = $('#token').val();//valido el token
                let Operario = $('#Operario').val();//valido el token


                if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                    if (Operario.length === 4) {
                        $('#ErrorDiv').hide();//si es bien no muestre
                        $('#BarcodeYaleido').hide();
                        $('#OperarioEror').hide();
                        $("#CodigoBarras").val('');//limpio campo

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},//toekn
                            data: DatosEviados,//datos que envio
                            //url: '/LoadInventoryEntry',//ruto post
                            url: '{{ route('LecturaEntradaProgpagacion') }}',//ruto post
                            type: 'post',
                            success: function (Result) {
                                // console.log(Result);
                                if (Result.data === 1) {
                                    $('#ErrorDiv').hide();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').hide();
                                    $('#errorCuartoFrio').hide();
                                    $('#erroEspacio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                    $('#Variedad').val(Result.consulta.Nombre_Variedad);
                                    $('#PLotid').val(Result.consulta.PlotIDNuevo);
                                    $('#CantPL').val(Result.consulta.PLantas);
                                    $('#CantBan').val(Result.consulta.Bandejas);
                                    $('#TotalBandBan').val(Result.consulta.TotalBandBan);

                                } else if (Result.data === 2) {
                                    $('#error')[0].play();
                                    $('#ErrorDiv').show();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').hide();
                                    $('#errorCuartoFrio').hide();
                                    $('#erroEspacio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                } else if (Result.data === 3) {
                                    $('#error')[0].play();
                                    $('#ErrorDiv').hide();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').show();
                                    $('#errorCuartoFrio').hide();
                                    $('#erroEspacio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                } else if (Result.data === 4) {
                                    $('#error')[0].play();
                                    $('#ErrorDiv').hide();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').hide();
                                    $('#errorCuartoFrio').show();
                                    $('#erroEspacio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                } else if (Result.data === 5) {
                                    $('#error')[0].play();
                                    $('#erroEspacio').show();//si es bien no muestre
                                    $('#ErrorDiv').hide();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').hide();
                                    $('#errorCuartoFrio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                } else {
                                    $('#error')[0].play();
                                    $('#ErrorDiv').show();
                                    $('#OperarioEror').hide();
                                    $('#BarcodeYaleido').hide();
                                    $('#errorCuartoFrio').hide();
                                    $('#erroEspacio').hide();
                                    $('#Operario').val('').focus();
                                    $('#CodigoBarras').val('');
                                }
                            }
                        });
                        return true;
                    } else {
                        $(document).ready(function () {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#OperarioEror').hide();
                            $('#BarcodeYaleido').hide();
                            $('#errorCuartoFrio').hide();
                            $('#erroEspacio').hide();
                            $('#Operario').val('').focus();
                            $('#CodigoBarras').val('');
                        });
                    }
                } else {
                    $(document).ready(function () {
                        $('#error')[0].play();
                        $('#ErrorDiv').show();
                        $('#OperarioEror').hide();
                        $('#BarcodeYaleido').hide();
                        $('#errorCuartoFrio').hide();
                        $('#erroEspacio').hide();
                        $('#Operario').val('').focus();
                        $('#CodigoBarras').val('');

                    });
                    return false;
                }
            });

            $('#idUbicacion').change(function () {
                let dato = $("#idUbicacion").val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: {dato},
                    url: '{{ route('EspacioBancos') }}',
                    type: 'post',
                    success: function (Result) {
                        if (Result.ok === 1) {
                            $('#error')[0].play();
                            //$('#OperarioBan').disable();
                            $("#OperarioBan").prop('disabled', true);
                            $("#Operario").prop('disabled', true);
                            $("#CodigoBarras").prop('disabled', true);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ubicación sin espacio',
                            });
                        } else if (Result.ok === 2) {
                            $("#OperarioBan").prop('disabled', false);
                            $("#Operario").prop('disabled', false);
                            $("#CodigoBarras").prop('disabled', false);
                        } else {
                            $('#error')[0].play();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salio mal',
                            });
                            $("#OperarioBan").prop('disabled', true);
                            $("#Operario").prop('disabled', true);
                            $("#CodigoBarras").prop('disabled', true);
                        }
                    }
                });
            });

            $("#Operario").change(function () {
                let dato = $("#Operario").val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: {dato},
                    url: '{{ route('ExisteOperario') }}',
                    type: 'post',
                    success: function (Result) {
                        if (Result.ok === 1) {
                            $('#error')[0].play();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Operario No existe',
                            });
                        } else {
                            $("#CodigoBarras").focus();
                        }
                    }
                });
            });
        });




    </script>
@endsection
