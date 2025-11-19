@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <div class=" card text-center">
            <h3 class="modal-title"><i class="fa fa-calculator" style="font-size: 40px; color: #0b97c4"></i> Calcular Pedido</h3>
        </div>
        <div class="container-fluid card card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <label class="col-form-label text-md-right">{{ __('Variedad') }}</label>
                            <input id="VariedadCalculada" value="{{ $datos->DetallesD->Nombre_Variedad }}" disabled class="form-control labelform"/>
                            <input type="hidden" id="CodigoVariedad" value="{{ $datos->DetallesD->Codigo }}" disabled class="form-control labelform"/>
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label text-md-right">{{ __('Factor Multiplicación') }}</label>
                            <input type="number" id="FactorPerdida" value="{{ $informacionTecnicaM->CoeficienteMultiplicacion }}" name="Factor" class="form-control labelform"/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="form-check col-lg-4">
                            {{--<input type="radio" class="form-check-input with-gap micheckbox" value="4" id="radioGap1" name="groupOfRadioGap">
                            <label class="form-check-label" for="radioGap1">Germo</label><br>
                            @if($Germos === null)
                                <input id="CantGermo" class="labelform" value="0" size="7" disabled>
                            @else
                                <input id="CantGermoD" class="labelform" value=" {{ $Germos->CanGermo  }}" size="7" disabled>
                            @endif
                        </div>
                        <div class="form-check col-lg-3">
                            <input type="radio" class="form-check-input with-gap micheckbox" value="5" id="radioGap2" name="groupOfRadioGap">
                            <label class="form-check-label" for="radioGap2">Stock</label><br>
                            @if($Stock === null)
                                <input id="CantStock" class="labelform" value="0" disabled>
                            @else
                                <input id="CantStockD" class="labelform" value="{{ $Stock->cantStock }}" size="7" disabled>
                            @endif--}}
                            <table>
                                <tr class="text-center">
                                    <td>
                                        <input type="radio" class="form-check-input with-gap micheckbox" value="4" id="radioGap1" name="groupOfRadioGap">
                                        <label class="form-check-label" for="radioGap1">Germo</label><br>
                                    </td>
                                    <td></td>
                                    <td>
                                        <input type="radio" class="form-check-input with-gap micheckbox" value="5" id="radioGap2" name="groupOfRadioGap">
                                        <label class="form-check-label" for="radioGap2">Stock</label><br>
                                    </td>
                                    <td> Programas y cantidad</td>
                                </tr>
                                <tr>
                                    <td>
                                        @if($Germos === null)
                                            <input id="CantGermo" class="labelform" value="0" size="7" disabled>
                                        @else
                                            <input id="CantGermoD" class="labelform" value=" {{ $Germos->CanGermo  }}" size="7" disabled>
                                        @endif
                                    </td>
                                    <td></td>
                                    <td>
                                        @if($Stock === null)
                                            <input id="CantStock" class="labelform" value="0" disabled>
                                        @else
                                            <input id="CantStockD" class="labelform" value="{{ $Stock->cantStock }}" size="7" disabled>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($programasFormados === null )
                                            <span>0/0</span>
                                        @else
                                            {{ $programasFormados->CantiRegistros }} /  {{ $programasFormados->CantPLantas }}
                                            <button type="button" class="btn btn-success btn-circle btn-sm" onclick="verprogramas({{ $programasFormados->id_Variedad }})" id="BtnVerProgramas" style="position: center">
                                                <i class="fas fa-eye" title="Ver"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-lg-8">


                            <div class="card direct-chat direct-chat-primary">
                                <div class="card-header ui-sortable-handle" style="cursor: move;">
                                    <h3 class="card-title">Programas Seleccionados</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body" style="display: block;">
                                    <div class="table table-responsive ">
                                        <table class="table table-hover" id="TablaDetallesPedido">
                                            <thead>
                                            <tr>
                                                <th>Identificador</th>
                                                <th>Semana Ultimo Movimiento</th>
                                                <th>Cantidad Plantas</th>
                                                <th>Fase</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php($count = 1)
                                            @forelse(  $GermosyStock as $GermosyStockd)
                                                <tr>
                                                    <td> {{ $GermosyStockd->Indentificador }} </td>
                                                    <td> {{ $GermosyStockd->SemanUltimoMovimiento }} </td>
                                                    <td> {{ $GermosyStockd->CantPlantas }} </td>
                                                    <td> {{ $GermosyStockd->NombreFase }} </td>
                                                </tr>
                                                @php($count++)
                                            @empty
                                                <div class="alert alert-warning">
                                                    <strong>No se encontraron datos</strong>
                                                </div>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-primary" id="Tablalaneacion" style="display: none; margin-top: 10px;">
                <form method="POST" id="DatosGuardarPLaneacion">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div class="col-lg-12" style="margin-top:10px; display: flex; justify-content:center; align-items: center;">
                        <h2> variedad solicitadas</h2>
                    </div>
                    <div class="card-primary text-center">
                        <label class="form-check-label" for="radioGap2">Cantidad</label>
                        <input id="CantidadCalculo" class="labelform monto" size="7" disabled>
                        <input name="stock" type="hidden" id="stock">
                        <input name="Germo" type="hidden" id="Germo">
                        <input name="CodigoVariedadd" type="hidden" value="{{ $datos->DetallesD->Codigo }}"/>
                        <input name="CodCabeza" type="hidden" value="{{ $datos->DetallesD->id_CabezaPedido }}"/>
                        <input name="FactorMulEdit" type="hidden" id="FactorMulEdit"/>
                    </div>
                    <div class="col-lg-12">
                        <div class="table table-responsive ">
                            <table class="table table-hover" id="TablaDetallesPedido">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Tipo Entrega</th>
                                    <th>Cantidad Solicitada</th>
                                    <th>Semana Solicitada</th>
                                    <th>Programas</th>
                                    <th>Semana Inicio</th>
                                    <th>Cantidad Inicio</th>
                                    <th>Cálculo Multiplicación</th>
                                    <th>Cálculo Enraizamiento</th>
                                    <th>Cálculo Adaptado</th>
                                    <th>Semana Despacho</th>
                                    <th>Acción</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($count = 1)
                                @forelse(  $datos->Detalles as $detallePedidoDs)

                                    @if( $detallePedidoDs->TipoEntrega === 'Invitro')
                                        <tr>
                                            <td> {{ $count }}
                                                <input type="hidden" id="contadorEn" name="contadorEn" value="{{ $count }}">
                                                <input type="hidden" id="idVariedad" name="idVariedad-{{$count}}" value="{{ $detallePedidoDs->id }}">
                                            </td>
                                            <td>
                                                {{ $detallePedidoDs->TipoEntrega }}
                                                <input type="hidden" name="TipoEntrega-{{$count}}" value="{{ $detallePedidoDs->TipoEntrega }}" id="TipoEntrega-{{$count}}">
                                            </td>
                                            <td> {{ $detallePedidoDs->CantidadInicial }}
                                                <input type="hidden" name="CantidadSolicitada-{{$count}}" value="{{ $detallePedidoDs->CantidadInicial }}" id="CantidadSolicitada-{{$count}}">
                                            </td>
                                            <td>
                                                @if($detallePedidoDs->SemanaEntrega =='N/A')
                                                    <label style="color: red">{{ $detallePedidoDs->SemanaEntrega }}</label>
                                                @else
                                                    {{ $detallePedidoDs->SemanaEntrega }}
                                                @endif
                                            </td>

                                            <td>
                                                <select class="selectpicker" multiple name="a[]-{{$count}}" id="a-{{$count}}">
                                                    @foreach($GermosyStock as $GermosyStockd)
                                                        <option value="{{ $GermosyStockd->Indentificador }}">{{ $GermosyStockd->Indentificador }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ProgramasH-{{$count}}" id="ProgramasH-{{$count}}">
                                            </td>

                                            <td>
                                                <input type="week" name="SemanaInicio-{{$count}}" class="labelform monto" id="SemanaInicio-{{$count}}">
                                            </td>
                                            <td>
                                                <input type="number" name="CantidadInicia-{{$count}}" class="labelform monto" id="CantidadInicio-{{$count}}">
                                            </td>
                                            <td>

                                                <table>
                                                    <tr>
                                                        <td>Ciclo Antes</td>
                                                        <td>Ciclo Final</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" id="SemanaMultiplicacionUnoantes-{{$count}}" name="SemanaMultiplicacionUnoantes-{{$count}}" size="7" disabled>
                                                            <input type="text" id="CantPlantasMultiplicacionUnoAntes-{{$count}}" name="CantPlantasMultiplicacionUnoAntes-{{$count}}" size="7" disabled>
                                                            <input type="hidden" id="SemanaMultiplicacionUnoantesH-{{$count}}" name="SemanaMultiplicacionUnoantesH-{{$count}}">
                                                            <input type="hidden" id="CantPlantasMultiplicacionUnoAntesH-{{$count}}" name="CantPlantasMultiplicacionUnoAntesH-{{$count}}">

                                                        </td>
                                                        <td>
                                                            <input type="text" id="SemanaMultiplicacionUnoDespues-{{$count}}" name="SemanaMultiplicacionUnoDespues-{{$count}}" size="7" disabled>
                                                            <input type="text" id="CantPlantasMultiplicacionUnoDespues-{{$count}}" name="CantPlantasMultiplicacionUnoDespues-{{$count}}" size="7" disabled>
                                                            <input type="hidden" id="SemanaMultiplicacionUnoDespuesH-{{$count}}" name="SemanaMultiplicacionUnoDespuesH-{{$count}}">
                                                            <input type="hidden" id="CantPlantasMultiplicacionUnoDespuesH-{{$count}}" name="CantPlantasMultiplicacionUnoDespuesH-{{$count}}">

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                <input type="text" id="SemanaEnraizamiento-{{$count}}" name="SemanaEnraizamiento-{{$count}}" size="7" disabled>
                                                <input type="text" id="CantEnreizar-{{$count}}" name="CantEnreizar-{{$count}}" size="7" disabled>
                                                <input type="hidden" id="SemanaEnraizamientoH-{{$count}}" name="SemanaEnraizamientoH-{{$count}}">
                                                <input type="hidden" id="CantEnreizarH-{{$count}}" name="CantEnreizarH-{{$count}}">
                                            </td>
                                            <td>
                                                <input type="hidden" id="SemanaAdaptacionH-{{$count}}" value="0" name="SemanaAdaptacionH-{{$count}}">
                                                <input type="hidden" id="cantAdaptacionH-{{$count}}" value="0" name="cantAdaptacionH-{{$count}}">
                                            </td>

                                            <td>
                                                <input type="text" id="SemanaDespacho-{{$count}}" name="SemanaDespacho-{{$count}}" size="7" disabled>
                                                <input type="hidden" id="SemanaDespachoH-{{$count}}" name="SemanaDespachoH-{{$count}}">
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-success" onclick="CalcularPedido('{{$count}}')" id="CalcularPedido">Calcular</a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td> {{ $count }}
                                                <input type="hidden" id="contadorEn" name="contadorEn" value="{{ $count }}">
                                                <input type="hidden" id="idVariedad" name="idVariedad-{{$count}}" value="{{ $detallePedidoDs->id }}">
                                            </td>
                                            <td>
                                                {{ $detallePedidoDs->TipoEntrega }}
                                                <input type="hidden" name="TipoEntrega-{{$count}}" value="{{ $detallePedidoDs->TipoEntrega }}" id="TipoEntrega-{{$count}}">
                                            </td>
                                            <td> {{ $detallePedidoDs->CantidadInicial }}
                                                <input type="hidden" name="CantidadSolicitada-{{$count}}" value="{{ $detallePedidoDs->CantidadInicial }}" id="CantidadSolicitada-{{$count}}">
                                            </td>
                                            <td>
                                                @if($detallePedidoDs->SemanaEntrega =='N/A')
                                                    <label style="color: red">{{ $detallePedidoDs->SemanaEntrega }}</label>
                                                @else
                                                    {{ $detallePedidoDs->SemanaEntrega }}
                                                @endif
                                            </td>
                                            <td>

                                                <select class="selectpicker" multiple name="a[]-{{$count}}" id="a-{{$count}}">
                                                    @foreach($GermosyStock as $GermosyStockd)
                                                        <option value="{{ $GermosyStockd->Indentificador }}">{{ $GermosyStockd->Indentificador }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="ProgramasH-{{$count}}" id="ProgramasH-{{$count}}">
                                            </td>
                                            <td>
                                                <input type="week" name="SemanaInicio-{{$count}}" class="labelform" id="SemanaInicio-{{$count}}">
                                            </td>
                                            <td>
                                                <input type="number" name="CantidadInicia-{{$count}}" class="labelform monto" id="CantidadInicio-{{$count}}">
                                            </td>
                                            <td>

                                                <table>
                                                    <tr>
                                                        <td>Ciclo Antes</td>
                                                        <td>Ciclo Final</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" id="SemanaMultiplicacionUnoantes-{{$count}}" name="SemanaMultiplicacionUnoantes-{{$count}}" size="7" disabled>
                                                            <input type="text" id="CantPlantasMultiplicacionUnoAntes-{{$count}}" name="CantPlantasMultiplicacionUnoAntes-{{$count}}" size="7" disabled>
                                                            <input type="hidden" id="SemanaMultiplicacionUnoantesH-{{$count}}" name="SemanaMultiplicacionUnoantesH-{{$count}}">
                                                            <input type="hidden" id="CantPlantasMultiplicacionUnoAntesH-{{$count}}" name="CantPlantasMultiplicacionUnoAntesH-{{$count}}">

                                                        </td>
                                                        <td>
                                                            <input type="text" id="SemanaMultiplicacionUnoDespues-{{$count}}" name="SemanaMultiplicacionUnoDespues-{{$count}}" size="7" disabled>
                                                            <input type="text" id="CantPlantasMultiplicacionUnoDespues-{{$count}}" name="CantPlantasMultiplicacionUnoDespues-{{$count}}" size="7" disabled>
                                                            <input type="hidden" id="SemanaMultiplicacionUnoDespuesH-{{$count}}" name="SemanaMultiplicacionUnoDespuesH-{{$count}}">
                                                            <input type="hidden" id="CantPlantasMultiplicacionUnoDespuesH-{{$count}}" name="CantPlantasMultiplicacionUnoDespuesH-{{$count}}">

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                {{--<input type="radio" class="radio" name="radio" value="En">--}}
                                                <input type="text" id="SemanaEnraizamiento-{{$count}}" name="SemanaEnraizamiento-{{$count}}" size="7" disabled>
                                                <input type="text" id="CantEnreizar-{{$count}}" name="SemanaEnraizamiento-{{$count}}" size="7" disabled>
                                                <input type="hidden" id="SemanaEnraizamientoH-{{$count}}" name="SemanaEnraizamientoH-{{$count}}">
                                                <input type="hidden" id="CantEnreizarH-{{$count}}" name="CantEnreizarH-{{$count}}">

                                            </td>
                                            <td>
                                                {{--<input type="radio" class="radio" name="radio" value="Adp">--}}
                                                <input type="text" id="SemanaAdaptacion-{{$count}}" name="SemanaAdaptacion-{{$count}}" size="7" disabled>
                                                <input type="text" id="cantAdaptacion-{{$count}}" name="cantAdaptacion-{{$count}}" size="7" disabled>

                                                <input type="hidden" id="SemanaAdaptacionH-{{$count}}" name="SemanaAdaptacionH-{{$count}}">
                                                <input type="hidden" id="cantAdaptacionH-{{$count}}" name="cantAdaptacionH-{{$count}}">

                                            </td>

                                            <td>
                                                <input type="text" id="SemanaDespacho-{{$count}}" name="SemanaDespacho-{{$count}}" size="7" disabled>
                                                <input type="hidden" id="SemanaDespachoH-{{$count}}" name="SemanaDespachoH-{{$count}}">
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-success" onclick="CalcularPedido('{{$count}}')" id="CalcularPedido">Calcular</a>
                                            </td>
                                        </tr>
                                    @endif

                                    @php($count++)
                                    <input id="contador2" value="{{ $count }}" type="hidden">
                                @empty

                                    <div class="alert alert-warning">
                                        <strong>No se encontraron datos</strong>
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a id="GuardarPlaneacion" class="btn btn-success btn-block">Guardar Planeación</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="VerProgramasEjecutados" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Programas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <table id="TablaDetallesProgramas" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                            <thead class="bg-blue-gradient">
                            <tr>
                                <th>Numero Pedido</th>
                                <th>Cantidad</th>
                                <th>Semana Despacho</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
    <script>
        $(document).ready(function () {
            let token = $('#token').val();
            $('#FactorMulEdit').val($('#FactorPerdida').val());
            $("#FactorPerdida").change(function () {
                $('#FactorMulEdit').val($('#FactorPerdida').val());
            });

            $("#radioGap1").click(function () {
                //console.log($('#CantGermoD').val());
                if ($('#CantGermoD').val() === '') {
                    $('#Tablalaneacion').hide();
                } else {
                    $('#Tablalaneacion').show();
                    $('#CantidadCalculo').val($('#CantGermoD').val());
                    $('#Germo').val($('#CantGermoD').val());
                }
            });
            $("#radioGap2").click(function () {
                if ($('#CantStockD').val() === '') {
                    $('#Tablalaneacion').hide();
                } else {
                    $('#Tablalaneacion').show();
                    $('#CantidadCalculo').val($('#CantStockD').val());
                    $('#stock').val($('#CantStockD').val());
                    $("#radio").prop("checked", false);
                }
            });

            $('#GuardarPlaneacion').on('click', function () {
                let contador = $('#contador2').val();
                contador = contador-1;
                for (let i = 1; i <= contador; i++) {
                    if ($('#SemanaDespachoH-' + contador).val() === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Debe Realizar la planeación para guardar!',
                        });
                        return false;
                    } else {
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},
                            data: $('#DatosGuardarPLaneacion').serialize(),
                            type: 'post',
                            dataType: 'json',
                            url: '{{ route('GuardarCalculoPedido') }}',//

                            success: function (Result) {
                                //console.log(Result);
                                if (Result.ok === 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Bien...',
                                        text: 'Bien!',
                                    });
                                    window.location.href = 'Orden/' + Result.id + '/pedido/Detalle';
                                } else if (Result.ok === 3) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error...',
                                        text: 'Debe Realizar la planeacion para guardar!',
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Algo salio mal!',
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });

        function verprogramas($ID) {
            let token = $('#token').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {data: $ID},
                type: 'post',
                dataType: 'json',
                url: '{{ route('VistaDetallasProgramasSaberEjecutados')}}',
                success: function (Result) {
                    console.log(Result);
                    if (Result.data === 1) {
                        var tbHtml = '';
                        $.each(Result.Programas, function (index, value) {
                            //console.log(Result.data.Codigo);
                            /* Vamos agregando a nuestra tabla las filas necesarias */
                            tbHtml += '<tr>' +
                                '<td>' + value.NumeroPedido + '</td>' +
                                '<td>' + value.CantidadInicialModificada + '</td>' +
                                '<td>' + value.SemanaPlaneacionDespacho + '</td>' +
                                '</tr>';

                        });
                        $('#TablaDetallesProgramas tbody').html(tbHtml);
                        $('#VerProgramasEjecutados').modal("show");
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Algo salio mal, llame al area de sistemas',
                        });
                    }
                }
            });

        }


        function CalcularPedido($count) {
            $('#ProgramasH-'+$count).val($('#a-' + $count).val());

            let germo = '';
            if ($('#radioGap1').prop('checked')) {
                germo = $('#CantGermoD').val();
            }
            let token = $('#token').val();
            let Semana = $('#SemanaInicio-' + $count).val();
            let Cantidad = $('#CantidadInicio-' + $count).val();
            let FactoMul = $('#FactorPerdida').val();
            let CodigoVariedad = $('#CodigoVariedad').val();
            let CantidadSolicitada = $('#CantidadSolicitada-' + $count).val();
            let TipoEntrega = $('#TipoEntrega-' + $count).val();
            let fase;

            $('.micheckbox:checked').each(
                function () {
                    fase = $(this).val();
                }
            );

            if (Semana === '' || Cantidad === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Digite Semana inicio y Cantidad inicial',
                });
            } else if ($('#ProgramasH-'+$count).val()==='') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Seleccione Un Programa',
                });
            }

            else {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {Semana: Semana, Cantidad: Cantidad, FactoMul: FactoMul, CantidadSolicitada: CantidadSolicitada, CodigoVariedad: CodigoVariedad, TipoEntrega: TipoEntrega, fase: fase, germo: germo},
                    type: 'post',
                    dataType: 'json',
                    url: '{{ route('CalcularPedido')}}',
                    success: function (Result) {
                        if (Result.data === 1) {
                            /*uno antes*/
                            $('#SemanaMultiplicacionUnoantes-' + $count).val(Result.SemanaMultiplicacionAntes);
                            $('#CantPlantasMultiplicacionUnoAntes-' + $count).val(Result.CantidadPlantasMultiplicacion);
                            $('#SemanaMultiplicacionUnoantesH-' + $count).val(Result.SemanaMultiplicacionAntes);
                            $('#CantPlantasMultiplicacionUnoAntesH-' + $count).val(Result.CantidadPlantasMultiplicacion);
                            /*uno despues*/
                            $('#SemanaMultiplicacionUnoDespues-' + $count).val(Result.SemanaMultiplicacion);
                            $('#CantPlantasMultiplicacionUnoDespues-' + $count).val(Result.CantidadPlantasMultiplicacionM);
                            $('#SemanaMultiplicacionUnoDespuesH-' + $count).val(Result.SemanaMultiplicacion);
                            $('#CantPlantasMultiplicacionUnoDespuesH-' + $count).val(Result.CantidadPlantasMultiplicacionM);

                            $('#SemanaEnraizamiento-' + $count).val(Result.SemanaEnraizamiento);
                            $('#CantEnreizar-' + $count).val(Result.PlanttasEnreiazar);
                            $('#SemanaEnraizamientoH-' + $count).val(Result.SemanaEnraizamiento);
                            $('#CantEnreizarH-' + $count).val(Result.PlanttasEnreiazar);

                            $('#SemanaAdaptacion-' + $count).val(Result.SemanaAdaptacion);
                            $('#cantAdaptacion-' + $count).val(Result.CantidadAdaptacion);
                            $('#SemanaAdaptacionH-' + $count).val(Result.SemanaAdaptacion);
                            $('#cantAdaptacionH-' + $count).val(Result.CantidadAdaptacion);

                            $('#SemanaDespacho-' + $count).val(Result.SEmanaDespacho);
                            $('#SemanaDespachoH-' + $count).val(Result.SEmanaDespacho);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salio mal!',
                            });
                        }
                    }
                });
            }
        }


    </script>
@endsection
