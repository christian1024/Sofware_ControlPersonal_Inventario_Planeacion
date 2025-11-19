@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Entrada Monitoreo</h3>
        </div>

        <div class="card border-secondary text-center">

            <div class="card-body">
                <form id="ViewLecturaInicioMonitoreo" method="get" action="{{ route('ViewLecturaInicioMonitoreo') }}">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                    <div class="">

                        <div class="form-row">
                            <div class="col-lg-4 ">
                                <label>Operario</label>
                                <input type="number" maxlength="4" minlength="3" class="labelform form-control" autocomplete="off" id="Operario" required name="Operario">
                            </div>


                            <div class="col-lg-4 ">
                                <label>Codigo de Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                            </div>

                            <div class="col-lg-4 ">

                                <i class="fa fa-calculator"><label> Contador</label></i>
                                <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                            </div>
                            <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                                <div class="col-lg-4 "></div>
                                <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                                    <label>ERROR CODIGO</label>
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

                        </div>

                    </div>
                    <button style="display: none" type="submit">guardar</button>
                </form>
            </div>
        </div>

    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center">
            <div style="display: flex; justify-content:center; align-items: center;">
                <h4>Ultima Lectura</h4>
            </div>
            <hr>

            <div class="row">

                <div class="col-lg-4">
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
                        <i class="fab fa-pagelines"> <label> Variedad</label></i>
                        <input id="VarLei" class="labelform form-group" disabled>

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
        let cout = 1;

        $('#ViewLecturaInicioMonitoreo').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#ViewLecturaInicioMonitoreo').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token
            let Operario = $('#Operario').val();//valido el token


            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                if (Operario.length >= 3) {
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('');//limpio campo

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        data: DatosEviados,//datos que envio
                        //url: '/LoadInventoryEntry',//ruto post
                        url: '{{ route('LecturaInicioMonitoreo') }}',//ruto post
                        type: 'post',
                        success: function (Result) {
                            //console.log(Result);
                            if (Result.data === 1) {
                                $('#BarcodeYaleido').hide();//si es bien no muestre
                                $('#OperarioEror').hide();
                                $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                                $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                                $('#EmpleadoL').val(Result.consulta[1].Primer_Nombre + ' ' + Result.consulta[1].Segundo_Nombre + ' ' + Result.consulta[1].Primer_Apellido + ' ' + Result.consulta[1].Segundo_Apellido);
                                $('#VarLei').val(Result.consulta[2].Nombre_Variedad);
                                $('#count').val(cout);
                                cout++;
                            } else {
                                $('#BarcodeLeido').css('border-color', 'red');
                                $('#BarcodeYaleido').show();
                                $('#ErrorDiv').hide();
                                $('#OperarioEror').hide();
                                $('#error')[0].play();
                                $('#patinadorFinal').val('');
                                $('#EmpleadoL').val('');
                                $('#Cantidalei').val('')
                                $('#VarLei').val('');
                            }

                        }
                    });
                    return true;
                } else {
                    $(document).ready(function () {
                        $('#error')[0].play();
                        $('#OperarioEror').show();
                        $('#ErrorDiv').hide();
                        $('#BarcodeYaleido').hide();
                        $("#Barcode").val('').css('border-color', 'red');
                        $('#patinadorFinal').val('');
                        $('#EmpleadoL').val('');
                        $('#Cantidalei').val('');
                        $('#VarLei').val('');
                    });
                }


            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $('#OperarioEror').hide();
                    $("#Barcode").val('').css('border-color', 'red');
                    $('#patinadorFinal').val('');
                    $('#EmpleadoL').val('');
                    $('#Cantidalei').val('');
                    $('#VarLei').val('');
                });
                return false;
            }
        });


    </script>
@endsection
