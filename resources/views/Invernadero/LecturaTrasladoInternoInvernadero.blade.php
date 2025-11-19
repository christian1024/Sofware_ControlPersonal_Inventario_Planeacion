@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Lectura Traslado Interno Inv</h3>
        </div>
        <form id="LecturaEntradaInvernadero" method="get" action="{{ route('VistaLecturaTrasladoInternoInvernadero') }}">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="box box-body col-lg-12">

                {{--<div class="col-lg-12">
                    <div class="col-lg-4 ">
                        <label>Patinador</label>
                    </div>
                    <div class="" style="text-align: right">
                        <select class="labelform" required name="IdPatinador">
                            <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                            @foreach($patinadores as $patinadore)
                                <option value="{{ $patinadore->id }}">
                                    {{$patinadore->Primer_Nombre }}
                                    {{$patinadore->Segundo_Nombre }}
                                    {{$patinadore->Primer_Apellido}}
                                    {{$patinadore->Segundo_Apellido}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
--}}
                <div class="form-row">

                    <div class="form-group col-lg-4">
                        <label>Fase</label>
                        <select class="labelform form-control" required id="Fase" name="Fase">
                            <option selected="true" value="" disabled="disabled">Seleccione Banco</option>
                            <option value="1">Fase 1</option>
                            <option value="2">Fase 2</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Banco</label>
                        <select class="labelform form-control" required id="IDCama" name="IDCama">
                            <option selected="true" value="" disabled="disabled">Seleccione Banco</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-4">
                        <label>Valvula</label>
                        <select class="labelform form-control" required id="idValvula" name="idValvula">
                            <option selected="true" value="" disabled="disabled">Seleccione Valvula</option>
                        </select>
                    </div>


                    <div class="form-group col-lg-4">
                        <label>Codigo de Barras</label>
                        <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                    </div>

                    <div class="form-group col-lg-4">

                        <i class="fa fa-calculator"><label> Contador</label></i>
                        <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                    </div>
                </div>

                {{-- <div class="col-lg-12 ">
                 </div>--}}

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

                <div id="OperarioEror" class="col-lg-12 " style="margin-top: 10px; display: none">
                    <div class="col-lg-4 "></div>
                    <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                        <label>OPERARIO NO EXISTE</label>
                    </div>
                    <div class="col-lg-4 "></div>
                </div>
            </div>
            <button style="display: none" type="submit">guardar</button>

        </form>
    </div>

    <div class="">
        <div class="card card-primary card-outline form-row text-center" >
            <div>
                <h4>Ultima Lectura</h4>
            </div>
            <hr>
            <div class="form-row">

                <div class="form-group col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-barcode"><label> Codigo Barras</label></i>
                        <input id="BarcodeLeido" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Empleado</label></i>
                        <input id="EmpleadoL" class="labelform form-group" disabled>
                    </div>
                </div>

                <div class="form-group col-lg-4">
                    <div class="col-lg-12">
                        <i class="fa fa-user-circle"><label> Patinador</label></i>
                        <input class="labelform form-group" id="patinadorFinal" disabled>
                    </div>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fab fa-pagelines"> <label> Variedad</label></i>
                        <input id="VarLei" class="labelform form-group" disabled>

                    </div>
                </div>

                <div class="form-group col-lg-4 ">
                    <div class="col-lg-12">
                        <i class="fa fa-list"><label> Cantidad</label></i>
                        <input id="Cantidalei" class="labelform form-group" disabled>
                    </div>
                </div>

                {{-- <div class="col-lg-4 ">
                     <div class="col-lg-12">
                         <img src="{{ asset('img/counter.png') }}" height="25" width="25">
                         <label>Contador</label>
                         <input style="position: center; text-align: center;" placeholder="0" class="labelform form-group" id="count" disabled>
                     </div>
                 </div>--}}
            </div>

            {{-- <span id="count"></span>--}}
            <audio id="error">
                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
            </audio>


        </div>


    </div>

    <script>
        let cout = 1;

        $('#Fase').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Banco/' + this.value + '/Banco',
                success: function (Result) {
                    //  console.log(Result);
                    $("#IDCama").empty().selectpicker('destroy').append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#IDCama").append('<option value="' + item.id + '">' + item.N_Cama + '</option>');
                    });
                    $('#IDCama').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    // console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });


        $('#IDCama').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cama/' + this.value + '/Cama',
                success: function (Result) {
                    //  console.log(Result);
                    $("#idValvula").empty().selectpicker('destroy').append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#idValvula").append('<option value="' + item.id + '">' + item.N_Seccion + '</option>');
                    });
                    $('#idValvula').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    // console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#LecturaEntradaInvernadero').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaEntradaInvernadero').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token
            let Operario = $('#Operario').val();//valido el token


            if (barcode.length === 9) { //valido ancho tanto minimo como maximo

                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $('#OperarioEror').hide();
                $("#Barcode").val('');//limpio campo

                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    //url: '/LoadInventoryEntry',//ruto post
                    url: '{{ route('LecturaTrasladoInternoInvernadero') }}',//ruto post
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
                            $('#Cantidalei').val(Result.consulta[2].Plantas);
                            $('#count').val(cout);
                            cout++;
                        } else if (Result.data === 0) {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#BarcodeYaleido').hide();
                            $('#OperarioEror').hide();
                            $('#patinadorFinal').val('');
                            $('#EmpleadoL').val('');
                            $('#Cantidalei').val('');
                            $('#VarLei').val('');
                            $("#Barcode").css('border-color', 'red').val('');
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#OperarioEror').hide();
                            $('#error')[0].play();
                            $('#patinadorFinal').val('');
                            $('#EmpleadoL').val('');
                            $('#Cantidalei').val('');
                            $('#VarLei').val('');
                        }

                    }
                });
                return true;


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
