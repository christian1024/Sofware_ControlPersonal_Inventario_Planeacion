@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        .DivCuartos {
            border-radius: 11px 11px 11px 11px;
            -webkit-box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);
            -moz-box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);
            box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);
        }

        .DivCuartosMod {
            /* border-radius: 8px 8px 8px 8px;*/
            /*-webkit-box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);
            -moz-box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);
            box-shadow: 0px 0px 13px 0px rgba(156, 148, 156, 1);*/
        }

        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }
    </style>

    <div class="box-body">
        <div class="col-lg-12" style="margin-top: -35px;">
            <h3>Distribucion de Cuartos</h3>
        </div>
    </div>

    <div class="col-lg-12">
        <div id="DistriCuartos" class="col-lg-12 box box-body spaceTap" style="margin-top: 10px">
            <ul>
                <li><a href="#CrearCuarto"><span>Estructurar Cuarto</span></a></li>

                <li><a href="#ModificarCuarto"><span>Modificar Cuarto</span></a></li>

            </ul>
            <hr>

            <div id="CrearCuarto" style="margin-top:10px" class="tabcontent col-lg-12">

                <div class="col-lg-4">
                    <div class="col-lg-12 DivCuartos">
                        <form id="CreateCuarto" method="POST" action="{{ route('CreateCuarto') }}" autocomplete="off">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div style="display: flex; justify-content:center; align-items: center;">
                                <h3>Crear Cuarto</h3>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <label for="Cuarto" style="display: flex; justify-content:center; align-items: center;" class="col-form-label text-md-right">{{ __('Cuarto') }}</label>
                                    <input class="form-control labelform" onkeypress="return justNumbers(event);" style=" text-align: center" name="Cuarto" required="required"/>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <label for="Cuarto" style="display: flex; justify-content:center; align-items: center;" class="col-form-label text-md-right">{{ __('Descripcion') }}</label>
                                    <textarea name="Descripcion" class="labelform col-lg-12" rows="3" cols="auto"> </textarea>
                                </div>
                            </div>

                            <div class="col-lg-12" style="margin-top: 25px">
                                <div class="col-lg-7"></div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 25px"></div>
                        </form>
                    </div>


                </div>

                <div class="col-lg-4">
                    <div class="col-lg-12 DivCuartos" STYLE="margin-left: 10px; ">
                        <form id="CreateEstanteCuarto" method="POST" action="{{ route('CreateEstanteCuarto') }}" autocomplete="off">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div style="display: flex; justify-content:center; align-items: center;">
                                <h3>Asignar Estante</h3>
                            </div>
                            <hr>
                            <div class="col-lg-12">
                                <div class="form-group col-lg-12">
                                    <label for="Cuarto" style="display: flex; justify-content:center; align-items: center;" name="idCuarto" class="col-form-label text-md-right">{{ __('Cuarto') }}</label>
                                    <select class="labelform form-control" required="required" name="id_Cuarto">
                                        <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                        @foreach($ultcuarto as $Cuarto)
                                            <option value="{{ $Cuarto->id  }}">{{__('Cuarto')}} {{ $Cuarto->N_Cuarto  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="Cuarto" class="col-form-label text-md-right" style="display: flex; justify-content:center; align-items: center;">{{ __('Estante') }}</label>
                                    <select class="selectpicker form-control" required="required" name="N_Estante[]" multiple data-selected-text-format="count > 10">
                                        <option selected="true" value="" disabled="disabled">Seleccione Estante</option>
                                        <option value="1">{{__('1')}} </option>
                                        <option value="2">{{__('2')}} </option>
                                        <option value="3">{{__('3')}} </option>
                                        <option value="4">{{__('4')}} </option>
                                        <option value="5">{{__('5')}} </option>
                                        <option value="6">{{__('6')}} </option>
                                        <option value="7">{{__('7')}} </option>
                                        <option value="8">{{__('8')}} </option>
                                        <option value="9">{{__('9')}} </option>
                                        <option value="10">{{__('10')}} </option>
                                        <option value="11">{{__('11')}} </option>
                                        <option value="12">{{__('12')}} </option>
                                        <option value="13">{{__('13')}} </option>
                                        <option value="14">{{__('14')}} </option>
                                        <option value="15">{{__('15')}} </option>
                                        <option value="16">{{__('16')}} </option>
                                        <option value="17">{{__('17')}} </option>
                                        <option value="18">{{__('18')}} </option>
                                        <option value="19">{{__('19')}} </option>
                                        <option value="20">{{__('20')}} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" style="">
                                <div class="col-lg-7"></div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 15px"></div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <form id="createNivelEstante" method="POST" action="{{ route('createNivelEstante') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="col-lg-12 DivCuartos" STYLE="margin-left: 10px; ">
                            <div style="display: flex; justify-content:center; align-items: center;">
                                <h3>Asignar Nivel</h3>
                            </div>
                            <hr>
                            <div class="form-group col-lg-12">
                                <div class="col-lg-4">
                                    <label for="Cuarto" class="col-form-label text-md-right">{{ __('Cuarto') }}</label>
                                </div>

                                <select class="labelform col-lg-8 col-md-12 col-xs-12" required="required" name="idCuarto" id="idCuarto">
                                    <option selected="true" value="" disabled="disabled">Seleccione Estante</option>
                                    @foreach($ultcuarto as $Cuarto)
                                        <option value="{{ $Cuarto->id  }}">{{__('Cuarto')}} {{ $Cuarto->N_Cuarto  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="col-lg-3">
                                    <label for="Cuarto" class="col-form-label text-md-right">{{ __('Estante') }}</label>
                                </div>
                                <div class="col-lg-9 col-md-9">
                                    <select name="idEstante" id="idEstante" class="col-lg-12 form-control labelform">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="col-lg-3 col-md-12 col-xs-12">
                                    <label for="Cuarto" class="col-form-label">{{ __('Nivel') }}</label>
                                </div>
                                <div class=" col-lg-9 col-md-9">
                                    <select class="selectpicker col-lg-12 col-md-12 col-xs-12" name="idNivel[]" multiple data-selected-text-format="count > 10">
                                        <option selected="true" value="" disabled="disabled">Seleccione Nivel</option>
                                        <option value="1">{{__('1')}} </option>
                                        <option value="2">{{__('2')}} </option>
                                        <option value="3">{{__('3')}} </option>
                                        <option value="4">{{__('4')}} </option>
                                        <option value="5">{{__('5')}} </option>
                                        <option value="6">{{__('6')}} </option>
                                        <option value="7">{{__('7')}} </option>
                                        <option value="8">{{__('8')}} </option>
                                        <option value="9">{{__('9')}} </option>
                                        <option value="10">{{__('10')}} </option>
                                        <option value="11">{{__('11')}} </option>
                                        <option value="12">{{__('12')}} </option>
                                        <option value="13">{{__('13')}} </option>
                                        <option value="14">{{__('14')}} </option>
                                        <option value="15">{{__('15')}} </option>
                                        <option value="16">{{__('16')}} </option>
                                        <option value="17">{{__('17')}} </option>
                                        <option value="18">{{__('18')}} </option>
                                        <option value="19">{{__('19')}} </option>
                                        <option value="20">{{__('20')}} </option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 5px">
                                <div class="col-lg-7"></div>
                                <div class="col-lg-3">
                                    <button class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 15px"></div>
                        </div>
                    </form>
                </div>


            </div>

            <div id="ModificarCuarto" class="tabcontent col-lg-12">
                <div class="col-lg-12 box box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <div class="col-lg-4">
                                <label class="col-form-label text-md-right">{{ __('Modificar Cuarto') }}</label>
                            </div>
                            <select class="form-group labelform col-lg-2">
                                @foreach($cuartos as $cuarto)
                                    <option value="{{ $cuarto->id }}"> {{ $cuarto->N_Cuarto }}</option>
                                @endforeach
                            </select>

                            <button id="mostrar" style="margin-left: 20px" class="btn btn-success btn-xs">Modificar</button>
                        </div>
                    </div>
                </div>
                <div id="ModOculto" style="display: none">
                    <div class="col-lg-12">
                        <div class="col-lg-6" style="border-style: groove;">
                            <div class="col-lg-12" style="display: flex; justify-content:center; align-items: center;">
                                <h3>Estantes</h3>
                            </div>
                            <div class="col-lg-12" style="display: flex; justify-content:center; align-items: center;">
                                <div class="col-lg-6">
                                    <input type="checkbox" name="vehicle1" value="Bike"> Esatnte 1<br>
                                    <input type="checkbox" name="vehicle2" value="Car"> Esatnte 1<br>
                                    <input type="checkbox" name="vehicle3" value="Boat" checked> Esatnte 1<br><br>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" name="vehicle1" value="Bike"> Esatnte 1<br>
                                    <input type="checkbox" name="vehicle2" value="Car"> Esatnte 1<br>
                                    <input type="checkbox" name="vehicle3" value="Boat" checked> Esatnte 1<br><br>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6" style="border-style: groove;">
                            <div class="col-lg-12" style="display: flex; justify-content:center; align-items: center;">
                                <h3>Pisos</h3>
                            </div>

                            <div class="col-lg-12" style="display: flex; justify-content:center; align-items: center;">
                                <div class="col-lg-6">
                                    <input type="checkbox" name="vehicle1" value="Bike"> piso 1<br>
                                    <input type="checkbox" name="vehicle2" value="Car"> piso 1<br>
                                    <input type="checkbox" name="vehicle3" value="Boat" checked> piso 1<br><br>
                                </div>
                                <div class="col-lg-6">
                                    <input type="checkbox" name="vehicle1" value="Bike"> piso 1<br>
                                    <input type="checkbox" name="vehicle2" value="Car"> piso 1<br>
                                    <input type="checkbox" name="vehicle3" value="Boat" checked> piso 1<br><br>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12" style="margin-top: 10px;">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1">
                            <button class="btn btn-success" type="submit">{{ __('Guardar') }}</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



    <script>

        $('#idCuarto').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cuarto/' + this.value + '/Cuarto',
                success: function (Result) {
                    console.log(Result);
                    $("#idEstante").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#idEstante").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                    });
                    $('#idEstante').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#DistriCuartos').tabs();

        $("#mostrar").click(function () {
            $("#ModOculto").show();
        });


        $(document).ready(function () {
            @if(session()->has('existe'))
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["error"]("El Cuarto ya se encuentra Creado");
            @endif

                    @if(session()->has('existeC'))
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["error"]("El Cuarto ya Tiene Estantes Asignados");
            @endif

                    @if(session()->has('existeE'))
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["error"]("El Estante ya Tiene Niveles Asignados");
            @endif

                    @if(session()->has('creado'))
                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-bottom-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["success"]("Creado Correctamente");
            @endif
        });


        function justNumbers(e) {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;

            return /\d/.test(String.fromCharCode(keynum));
        }


    </script>
@endsection
