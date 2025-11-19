@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">

        <div class="col-lg-12">
            <h2 style="text-align: center">Lectura Salida</h2>
        </div>
        <div class="card border-primary text-center">
            <div class="col-lg-12">
                <label>Tipo De Salida</label>
                <select class="labelform text-center" name="cambiar" id="cambiar">
                    <option selected="true" value="" disabled="disabled">Seleccione uno..</option>
                    @foreach($TipSalidas as $TipSalida)
                        <option value="{{ $TipSalida->id }}"> {{ $TipSalida->TipoSalida_Ajuste }} </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div id="Cancelado" style="display: none">
            <div class="card">
                <div>
                    <h2 style="text-align: center">Cancelacion</h2>
                </div>
                <div class="card-body">
                    <form id="SalidaXCancelacion" method="post" action="{{ route('SalidaXCancelacion') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tokenc">
                        <input type="hidden" value="4" name="id_TipoSalidaC">
                        <div class="form-row">
                            <div class="col-lg-6 ">
                                <label>Tipo Cancelacion</label>
                                <select class="labelform form-control" name="idCausalDañoC">
                                    <option value="20">Cancelación por Cliente</option>
                                    <option value="25">Salida por diferencia arqueo</option>
                                    <option value="27">Renovación</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Codigo Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="BarcodeC" required name="BarcodeC">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="DañoMaterial" style="display: none">
            <div class="card">
                <div>
                    <h2 style="text-align: center">Daño Material</h2>
                </div>
                <div class="card-body">
                    <form id="SalidaXDañoMaterial" method="post" action="{{ route('SalidaXDañoMaterial') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tokendm">
                        <input type="hidden" value="5" name="id_TipoSalidadm">


                        <div class="form-row" style="margin-top: 5px">
                            <div class="col-lg-6 ">
                                <label>Tipo Daño</label>
                                <select class="labelform form-control" required name="id_TipoDañodm">
                                    @foreach( $causales as $causale)
                                        <option value="{{ $causale->id }}"> {{ $causale->CausalDescarte }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label>Codigo Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="Barcodedm" required name="Barcodedm">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="Despacho" style="display: none">
            <div class="card">
                <div>
                    <h2 style="text-align: center">Despacho</h2>
                </div>
                <div class="card-body">
                    <form id="SalidaXDespacho" method="post" action="{{ route('SalidaXDespacho') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tokend">
                        <input type="hidden" value="6" name="id_TipoSalida_d">
                        <div class="col-lg-12" style="margin-top: 5px">
                            <div class="col-lg-6">
                                <label>Codigo Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="Barcoded" required name="Barcoded">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="Produccion" style="display: none">
            <div class="card">
                <div>
                    <h2 style="text-align: center">Produccion</h2>
                </div>
                <div class="card-body">
                    <form id="SalidaAProduccion" method="post" action="{{ route('SalidaAProduccion') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tokenp">
                        <input type="hidden" value="8" name="id_TipoSalidap">
                        <div class="col-lg-12" style="margin-top: 5px">
                            <div class="col-lg-6">
                                <label>Codigo Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="BarcodeP" required name="BarcodeP">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="Sobrantes" style="display: none">
            <div class="card">
                <div>
                    <h2 style="text-align: center">Sobrantes</h2>
                </div>
                <div class="card-body">
                    <form id="SalidaXsobrantes" method="post" action="{{ route('SalidaXsobrantes') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="tokenS">
                        <input type="hidden" value="9" name="id_TipoSalidaS">
                        <div class="col-lg-12" style="margin-top: 5px">
                            <div class="col-lg-6">
                                <label>Codigo Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="BarcodeS" required name="BarcodeS">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>ERROR BARCODE</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>

        <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>BARCODE YA FUE LEIDO</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>


        <div id="SinResultadoMuestra" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>SIN RESULTADO MUESTRA</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>

        <div id="MuestraPositiva" class="col-lg-12 " style="margin-top: 10px; display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>MUESTRA POSITIVA</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>


    </div>

    <div class="text-center">
        <div class="card card-primary card-outline">
            <div>
                <h4>Ultima Lectura</h4>
            </div>
            <hr>

            <div class="form-row">

                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-calculator"><label> Contador</label></i>
                        <input style="position: center; text-align: center;" placeholder="0" class="labelform form-group" id="count" disabled>
                    </div>
                </div>

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


            </div>

            <div class="form-row">

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Patinador</label></i>
                        <input class="labelform form-group" id="patinadorFinal" disabled>
                    </div>
                </div>

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fab fa-pagelines"> <label> Variedad</label></i>
                        <input id="VarLei" class="labelform form-group" disabled>

                    </div>
                </div>

                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-list"><label> Cantidad</label></i>
                        <input id="Cantidalei" class="labelform form-group" disabled>
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
        let cout1 = 1;
        let cout2 = 1;
        let cout3 = 1;
        let cout4 = 1;
        let cout5 = 1;
        $('#cambiar').change(function () {
            let valorCambiado = $(this).val();
            $('#DatosLeidos').trigger("reset");
            if (valorCambiado === '5') {

                $('#DañoMaterial').show();
                $('#Despacho').hide();
                $('#Cancelado').hide();
                $('#Produccion').hide();
                $('#Sobrantes').hide();
            } else if (valorCambiado === '6') {

                $('#DañoMaterial').hide();
                $('#Despacho').show();
                $('#Cancelado').hide();
                $('#Produccion').hide();
                $('#Sobrantes').hide();
            } else if (valorCambiado === '4') {

                $('#DañoMaterial').hide();
                $('#Despacho').hide();
                $('#Cancelado').show();
                $('#Produccion').hide();
                $('#Sobrantes').hide();
            } else if (valorCambiado === '7') {
                $('#DañoMaterial').hide();
                $('#Despacho').hide();
                $('#Cancelado').hide();
                $('#Produccion').hide();
                $('#Sobrantes').hide();
            } else if (valorCambiado === '8') {

                $('#DañoMaterial').hide();
                $('#Despacho').hide();
                $('#Cancelado').hide();
                $('#Produccion').show();
                $('#Sobrantes').hide();
            } else if (valorCambiado === '9') {

                $('#DañoMaterial').hide();
                $('#Despacho').hide();
                $('#Cancelado').hide();
                $('#Produccion').hide();
                $('#Sobrantes').show();
            }
        });

        $('#SalidaXCancelacion').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#SalidaXCancelacion').serialize();//paso todos los datos del for a una variable
            let barcode = $("#BarcodeC").val();//asigno input a una variable para validar
            let token = $('#tokenc').val();//valido el token

            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#BarcodeC").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{ route('SalidaXCancelacion') }}",
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result.consulta);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            $('#count').val(cout);
                            cout++;
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            });
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                        }

                    }
                });

                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#BarcodeC").val('').css('border-color', 'red');

                });
                return false;
            }
        });

        $('#SalidaXDañoMaterial').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#SalidaXDañoMaterial').serialize();
            let barcode = $("#Barcodedm").val();
            let token = $('#tokendm').val();

            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#Barcodedm").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{route('SalidaXDañoMaterial')}}",//ruto post
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            $('#count').val(cout1);
                            cout1++;
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            });
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }

                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#Barcodedm").val('').css('border-color', 'red');
                });
                return false;
            }
        });

        $('#SalidaXDespacho').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#SalidaXDespacho').serialize();
            let barcode = $("#Barcoded").val();
            let token = $('#tokend').val();

            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#Barcoded").val('');//limpio campo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{route('SalidaXDespacho')}}",//ruto post
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            $('#count').val(cout2);
                            cout2++;
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            });
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#Barcoded").val('').css('border-color', 'red');
                });
                return false;
            }
        });

        $('#SalidaAProduccion').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#SalidaAProduccion').serialize();
            let barcode = $("#BarcodeP").val();
            let token = $('#tokenp').val();
            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#BarcodeP").val('');//limpio campo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{route('SalidaAProduccion')}}",//ruto post
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            /*$('#patinadorFinal').val(Result.consulta.Primer_Nombre + ' ' + Result.consulta.Segundo_Nombre + ' ' + Result.consulta.Primer_Apellido + ' ' + Result.consulta.Segundo_Apellido);*/
                            $('#count').val(cout4);
                            cout4++;
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            });
                        } else if (Result.data === 3) {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#SinResultadoMuestra').show();//si es bien no muestre
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        } else if (Result.data === 4) {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#MuestraPositiva').show();//si es bien no muestre
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                            $('#SinResultadoMuestra').hide();//si es bien no muestre
                            $('#MuestraPositiva').hide();//si es bien no muestre
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#BarcodeP").val('').css('border-color', 'red');
                    $('#SinResultadoMuestra').hide();//si es bien no muestre
                    $('#MuestraPositiva').hide();//si es bien no muestre
                });
                return false;
            }
        });

        $('#SalidaXsobrantes').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#SalidaXsobrantes').serialize();
            let barcode = $("#BarcodeS").val();
            let token = $('#tokenS').val();

            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#BarcodeS").val('');//limpio campo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{route('SalidaXsobrantes')}}",//ruto post
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            /*$('#patinadorFinal').val(Result.consulta.Primer_Nombre + ' ' + Result.consulta.Segundo_Nombre + ' ' + Result.consulta.Primer_Apellido + ' ' + Result.consulta.Segundo_Apellido);*/
                            $('#count').val(cout5);
                            cout5++;
                        } else if (Result.data === 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            });
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#BarcodeS").val('').css('border-color', 'red');
                });
                return false;
            }
        });

    </script>
@endsection
