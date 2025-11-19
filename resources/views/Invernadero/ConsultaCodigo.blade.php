@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
        <div class="card">
            <div class="panel-heading">
                <h3 style="text-align: center">Detalles Bandeja</h3>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-12">
                            <form id="ConsutlaCodigo" method="get" action="{{ route('VistaConsultaCodigoInvernadero') }}">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <label>Codigo de Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                            </form>
                        </div>
                    </div>

                    <div class="">
                        <div class="box box-body col-lg-12" style="text-align: center">
                            <div style="margin-top:-15px; display: flex; justify-content:center; align-items: center;">
                                <h4>Ultima Lectura</h4>
                            </div>
                            <hr>
                            <div class="row">
                                <div class=" col-lg-4">
                                    <div class="col-lg-12">
                                        <i class="fa fa-barcode"><label> Codigo Barras</label></i>
                                        <input id="BarcodeLeido" class="labelform form-group" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="col-lg-12">
                                        <i class="fa fa-user-circle"><label> Empleado</label></i>
                                        <input id="EmpleadoL" class="labelform form-group" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4 ">
                                    <div class="col-lg-12">
                                        <i class="fa fa-user-circle"><label> Patinador</label></i>
                                        <input class="labelform form-group" id="patinadorFinal" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 ">
                                    <div class="col-lg-12">
                                        <i class="fab fa-pagelines"> <label>N. Variedad</label></i>
                                        <input id="VarLei" class="labelform form-group" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="col-lg-12">
                                        <i class="fa fa-list"><label> Cantidad</label></i>
                                        <input id="Cantidalei" class="labelform form-group" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-4 ">
                                    <div class="col-lg-12">
                                        <i class="fa fa-location-arrow"> <label>Ubicación</label></i>
                                        {{--<img src="{{ asset('img/cantidad.png') }}" height="25" width="25">--}}

                                        <input id="Ubicacion" class="labelform form-group" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <span id="count"></span>--}}
                        <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                            <div class="col-lg-4 "></div>
                            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                                <label>SIN ENTRADA O INACTIVO</label>
                            </div>
                            <div class="col-lg-4 "></div>
                        </div>

                        <div id="ErrorDiv2" class="col-lg-12 " style="margin-top: 10px; display: none">
                            <div class="col-lg-4 "></div>
                            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                                <label>CODIGO ERRONEO</label>
                            </div>
                            <div class="col-lg-4 "></div>
                        </div>

                        <audio id="error">
                            <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
                        </audio>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#ConsutlaCodigo').submit(function (event) {
                event.preventDefault();
                let DatosEviados = $('#ConsutlaCodigo').serialize();//paso todos los datos del for a una variable
                let barcode = $("#Barcode").val();//asigno input a una variable para validar
                let token = $('#token').val();//valido el token


                if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('');//limpio campo

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        data: DatosEviados,//datos que envio
                        //url: '/LoadInventoryEntry',//ruto post
                        url: '{{ route('LecturaConsultaCodigoInvernadero') }}',//ruto post
                        type: 'post',
                        success: function (Result) {
                            // console.log(Result);
                            if (Result.data === 1) {
                                $('#BarcodeYaleido').hide();//si es bien no muestre
                                $('#OperarioEror').hide();
                                $('#ErrorDiv2').hide();
                                $('#ErrorDiv').hide();
                                $('#BarcodeLeido').css('border-color', '').val(Result.consulta[0].CodigoBarras);
                                $('#patinadorFinal').val(Result.consulta[0].NombrePatinador);
                                $('#EmpleadoL').val(Result.consulta[0].NombreOperario);
                                $('#VarLei').val(Result.consulta[0].Nombre_Variedad);
                                $('#Cantidalei').val(Result.consulta[0].Plantas);
                                $('#Ubicacion').val(Result.consulta[0].UbicacionActual);

                            } else if (Result.data === 2) {
                                $('#error')[0].play();
                                $('#ErrorDiv').show();
                                $('#ErrorDiv2').hide();
                                $('#BarcodeLeido').css('border-color', '').val(barcode);
                                $('#patinadorFinal').val('');
                                $('#EmpleadoL').val('');
                                $('#VarLei').val('');
                                $('#Cantidalei').val('');
                                $('#Ubicacion').val('');
                            }
                        }
                    });

                    return true;
                } else {
                    $('#error')[0].play();
                    $('#ErrorDiv2').show();
                    $('#ErrorDiv').hide();
                    $("#Barcode").val('');
                    $("#BarcodeLeido").val(barcode).css('border-color', 'red');
                    $('#patinadorFinal').val('');
                    $('#EmpleadoL').val('');
                    $('#Cantidalei').val('');
                    $('#VarLei').val('');

                    return false;
                }
            });
        });

    </script>
@endsection

