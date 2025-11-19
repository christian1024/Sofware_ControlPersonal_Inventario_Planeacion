@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }
    </style>


    <div class="content-header col-lg-12">
    <div class="card card-primary card-outline col-lg-12">
        <div style="margin-top:15px; display: flex; justify-content:center; align-items: center;">

        <h4>Lectura entrada</h4>
        </div>
        <hr>
        <form id="LecturaEntradaCFProd" method="get" action="{{ route('LecturaEntradaCFProd') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="box box-body col-lg-12" style="margin-bottom: 20px">

                    <div class="col-lg-12 ">
                        <div class="row">
                    <div class="col-lg-6 ">

                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                    </div>

                    <div class="col-lg-6 ">

                        <img src="{{ asset('Principal/img/counter.png') }}" height="25" width="25">
                        <label>Contador</label>
                        <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

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
                <div id="BarcodeNoInventario" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>BARCODE NO ESTA EN INVENTARIO</label>
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
                <div id="BarcodeLavandula" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR, CODIGO PERTENECE A LAVANDULA</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>
                <div id="BarcodeRosmarinus" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR, CODIGO PERTENECE A ROSMARINUS</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>

                <div id="BarcodeLITHODORA" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>ERROR, CODIGO PERTENECE A LITHODORA</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>
            </div>
            <button style="display: none" type="submit">guardar</button>
        </form>
    </div>


    <div class="card card-primary card-outline col-lg-12">
        <div class="box box-body col-lg-12">
            <div style="margin-top:15px; display: flex; justify-content:center; align-items: center;">
                <h4>Ultima Lectura</h4>
            </div>
            <hr>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="col-lg-12">
                            <img src="{{ asset('Principal/img/BarCode.png') }}" height="25" width="25">
                            <label>Codigo Barras</label>
                            <input id="BarcodeLeido" class="labelform form-group" disabled>
                        </div>
                    </div>
                <div class="col-lg-4 ">
                    <div class="col-lg-12">
                        <img src="{{ asset('Principal/img/001-planta.png') }}" height="25" width="25">
                        <label>Variedad</label>
                        <input id="VarLei" class="labelform form-group" disabled>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-lg-12">
                        <img src="{{ asset('Principal/img/caja.ico') }}" height="25" width="25">
                        <label>Numero Caja</label>
                        <input id="Caja" class="labelform form-group" disabled>
                    </div>
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
        $('#LecturaEntradaCFProd').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaEntradaCFProd').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token

            if (barcode.length === 9){
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#Barcode").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: '/LecturaEntradaCFProd',//ruto post
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result.data);
                        if (Result.data === 1){
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();
                            $('#BarcodeLavandula').hide();
                            $('#BarcodeRosmarinus').hide();
                            $('#BarcodeLITHODORA').hide();//si es bien no muestre
                            $('#Barcode').css('border-color', '');
                            $('#BarcodeLeido').css('border-color', '');
                            $('#BarcodeLeido').val(Result.barcode);
                            $('#VarLei').val(Result.ultimalectura.Nombre_Variedad);
                            $('#Caja').val(Result.ultimalectura.Caja);
                            $('#count').val(cout);
                            cout++;
                        } else if (Result.data === 2){
                            $('#error')[0].play();
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').show();//si es bien no muestre
                            $('#BarcodeLavandula').hide();//si es bien no muestre
                            $('#BarcodeRosmarinus').hide();//si es bien no muestre
                            $('#BarcodeLITHODORA').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();
                            $("#Barcode").val('');
                            $("#Barcode").css('border-color', 'red');
                            $('#VarLei').val('');
                            $('#Caja').val('');
                        }else if (Result.data === 3){
                            $('#error')[0].play();
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();
                            $('#BarcodeLavandula').show();//si es bien no muestre
                            $('#BarcodeRosmarinus').hide();//si es bien no muestre
                            $('#BarcodeLITHODORA').hide();//si es bien no muestre
                            $("#Barcode").val('');
                            $("#Barcode").css('border-color', 'red');
                            $('#VarLei').val('');
                            $('#Caja').val('');
                        }else if (Result.data === 4){
                            $('#error')[0].play();
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();
                            $('#BarcodeLavandula').hide();//si es bien no muestre
                            $('#BarcodeLITHODORA').hide();//si es bien no muestre
                            $('#BarcodeRosmarinus').show();//si es bien no muestre
                            $("#Barcode").val('');
                            $("#Barcode").css('border-color', 'red');
                            $('#VarLei').val('');
                            $('#Caja').val('');
                        }else if (Result.data === 5){
                            $('#error')[0].play();
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').hide();//si es bien no muestre
                            $('#BarcodeYaleido').hide();
                            $('#BarcodeLavandula').hide();//si es bien no muestre
                            $('#BarcodeRosmarinus').hide();//si es bien no muestre
                            $('#BarcodeLITHODORA').show();//si es bien no muestre
                            $("#Barcode").val('');
                            $("#Barcode").css('border-color', 'red');
                            $('#VarLei').val('');
                            $('#Caja').val('');
                        }
                        else {
                            $('#error')[0].play();
                            $('#ErrorDiv').hide();//si es bien no muestre
                            $('#BarcodeNoInventario').hide();//si es bien no muestre
                            $('#BarcodeYaleido').show();
                            $('#BarcodeLavandula').hide();
                            $('#BarcodeRosmarinus').hide();
                            $('#BarcodeLITHODORA').hide();//si es bien no muestre
                            $("#Barcode").val('');
                            $("#Barcode").css('border-color', 'red');
                            $('#VarLei').val('');
                            $('#Caja').val('');
                        }
                    }
                });
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeNoInventario').hide();
                    $('#BarcodeYaleido').hide();
                    $('#BarcodeLavandula').hide();
                    $('#BarcodeRosmarinus').hide();
                    $("#Barcode").val('');
                    $("#Barcode").css('border-color', 'red');
                    $('#VarLei').val('');
                    $('#Caja').val('');
                });
                return false;
            }
        });

    </script>

@endsection
