@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h3>Arqueo Inventario</h3>
        </div>
        @can('LecturaArqueo')
            <div class="card border-secondary text-center">
                <div class="card-body">
                    <form id="LecturaArqueo" method="get" action="{{ route('LecturaArqueo') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="box box-body col-lg-12">

                            <div class="form-row ">
                                <div class="form-group col-lg-4 ">
                                    <label>Cuarto</label>
                                    <select class="labelform form-control" required id="IDCuarto" name="IDCuarto">
                                        <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                        @foreach( $cuartosAc as $cuartosAcv)
                                            <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-lg-4 ">
                                    <label>Estante</label>

                                    <select class="labelform form-control" required id="IDEstante" name="IDEstante">
                                        <option selected="true" value="" disabled="disabled">Seleccione Estante</option>

                                    </select>

                                </div>

                                <div class="form-group col-lg-4 ">
                                    <label>Nivel</label>

                                    <select class="labelform form-control" id="IDPiso" required name="IDPiso">
                                        <option selected="true" value="" disabled="disabled">Seleccione Estante</option>

                                    </select>

                                </div>
                            </div>

                            <div class="form-row ">

                                <div class=" form-group col-lg-4 ">
                                    <label>Codigo de Barras</label>
                                    <input type="text" class="labelform form-control" autocomplete="off" id="Barcode" required name="Barcode">
                                </div>

                                <div class=" form-group col-lg-4 ">

                                    <i class="fa fa-calculator"><label> Contador</label></i>
                                    <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="count" disabled>

                                </div>

                                <div class="form-group col-lg-4 ">

                                    <i class="fa fa-barcode"><label> Codigo Barras</label></i>
                                    <input style="position: center; text-align: center;" placeholder="0" class="labelform form-control" id="BarcodeLeido" disabled>
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
                            <audio id="error">
                                <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
                            </audio>

                        </div>

                        <button style="display: none" type="submit">guardar</button>

                    </form>
                </div>
            </div>
        @endcan
    </div>
    <div class="card">
        <div class="box box-body col-lg-12">
            <h4>Cruce Inventario</h4>
            {{-- @can('IniciarInventario')
                 <div class="col-lg-12">
                     <button class="btn btn-primary">
                         Iniciar Inventario
                     </button>
                 </div>
             @endcan--}}
            @can('TablaLecturaArqueo')
                <div class="col-lg-12">
                    <div class="box box-body table-responsive">
                        <table id="TableInventarioFaltante" class="table table-bordered table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>Codigo Entrada</th>
                                <th>Ubicacion Entrada</th>
                                <th>Estado Entrada</th>
                                <th>Codigo Arqueo</th>
                                <th>Ubicacion Arqueo</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $Arqueo as $Arqueos)
                                @if($Arqueos->CodigoEntrada === $Arqueos->CodigoArqueo && $Arqueos->UbicacionEntrada === $Arqueos->UbicacionArqueo && $Arqueos->EstadoEntrada === 'Activo')
                                    {{--  <tr>
                                          <td>{{ $Arqueos->CodigoEntrada }}</td>
                                          <td>{{ $Arqueos->UbicacionEntrada }}</td>
                                          <td>{{ $Arqueos->EstadoEntrada }}</td>
                                          <td>{{ $Arqueos->CodigoArqueo }}</td>
                                          <td>{{ $Arqueos->UbicacionArqueo }}</td>
                                          <td>OK</td>
                                      </tr>--}}
                                @else
                                    <tr>
                                        <td>{{ $Arqueos->CodigoEntrada }}</td>
                                        <td>{{ $Arqueos->UbicacionEntrada }}</td>
                                        <td>{{ $Arqueos->EstadoEntrada }}</td>
                                        <td>{{ $Arqueos->CodigoArqueo }}</td>
                                        <td>{{ $Arqueos->UbicacionArqueo }}</td>

                                        @if(empty($Arqueos->CodigoEntrada))

                                            <td>Sin lectura de entrada</td>

                                        @elseif(empty($Arqueos->CodigoArqueo))

                                            <td>No leído en arqueo</td>

                                        @elseif($Arqueos->CodigoEntrada = $Arqueos->CodigoArqueo && $Arqueos->EstadoEntrada ==='Inactivo' && $Arqueos->UbicacionEntrada <> $Arqueos->UbicacionArqueo)

                                            <td>Ubicacion no conincide, Inactivo</td>

                                        @elseif($Arqueos->CodigoEntrada = $Arqueos->CodigoArqueo && $Arqueos->EstadoEntrada ==='Activo' && $Arqueos->UbicacionEntrada <> $Arqueos->UbicacionArqueo)

                                            <td>Ubicacion no conincide, Activo</td>

                                        @elseif($Arqueos->CodigoEntrada = $Arqueos->CodigoArqueo && $Arqueos->EstadoEntrada ==='Inactivo')

                                            <td>Ya se realizó salida</td>

                                        @endif


                                    </tr>
                                @endif
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            @endcan
        </div>
    </div>

    <script>
        let cout = 1;
        $('#IDCuarto').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cuarto/' + this.value + '/Cuarto',
                success: function (Result) {
                    //  console.log(Result);
                    $("#IDEstante").empty().selectpicker('destroy');
                    $("#IDEstante").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEstante").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                    });
                    $('#IDEstante').selectpicker({
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

        $('#IDEstante').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Estante/' + this.value + '/Estante',
                success: function (Result) {
                    //console.log(Result);
                    $("#IDPiso").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDPiso").append('<option value="' + item.id + '">' + item.N_Nivel + '</option>');
                    });
                    $('#IDPiso').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#LecturaArqueo').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecturaArqueo').serialize();//paso todos los datos del for a una variable
            let barcode = $("#Barcode").val();//asigno input a una variable para validar
            let token = $('#token').val();//valido el token


            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{ route('LecturaArqueo') }}",
                    type: 'post',
                    success: function (Result) {
                        //console.log(Result);
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $("#Barcode").val('');
                            $('#count').val(cout);
                            cout++;
                        } else if (Result.data === 2) {
                            $('#error')[0].play();
                            $('#ErrorDiv').show();
                            $('#BarcodeYaleido').hide();
                            $("#Barcode").val('').css('border-color', 'red');
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red').val(Result.barcode);
                            $("#Barcode").val('');
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


        $(document).ready(function () {
             $('#TableInventarioFaltante').DataTable({
                "info": true,
                dom: 'Bfrtip',
                destroy: true,
                paging: true,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_  ",
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
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
        });
    </script>


@endsection
