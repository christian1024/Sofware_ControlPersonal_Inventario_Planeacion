@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card card-body content row">
        <div class="col-12 text-center">
            <h3 class="modal-title"><i class="fa fa-play" style="font-size: 40px; color: #0b97c4"></i> SIMULADOR</h3>
        </div>
        <div class="row card card-body">
            <div class="col-lg-12">
                <label class=" col-form-label text-md-right">{{ __('Tipo Simulación') }}</label>
                <select class="selectpicker" id="TipoSimulacion">
                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                    <option value="1">Proyección</option>
                    <option value="2">Regresion</option>

                </select>
            </div>
        </div>

        <div class="card card-body content row" id="divProyección" style="display: none">
            <div class="text-center">
                <h3><STRONG> PROYECCIÓN</STRONG></h3>
            </div>
            <div class="row">
                <div class="row col-lg-12">
                    <div class="col-lg-3">
                        <label class=" col-form-label text-md-right">{{ __('Variedad') }}</label>
                        <select class="selectpicker" data-show-subtext="true" id="Variedad" data-live-search="true">
                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                            @foreach($Variedades as $Variedad)
                                <option value="{{ $Variedad->id }}">{{ $Variedad->Codigo }} {{ $Variedad->Nombre_Variedad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="DatosVisuales1" class="col-lg-9" style="display: none">
                        <div class="row col-lg-12">

                            <div class="col-lg-3">
                                <label class="col-form-label text-md-right">{{ __('Factor') }}</label>
                                <input id="Factor" name="factor"/>
                            </div>

                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Introducciones</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-lg-12">
                                                <table id="TableIntroducciones" class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Introducción</th>
                                                        <th>Semana Ultimo Mov</th>
                                                        <th>Fase</th>
                                                        <th>Cantidad Plantas</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12" id="TablaSimulacionProyeccion" style="display: none">
                    <hr style=" height: 1px;  background-color: #0b97c4;">
                    <table class="table table-sm">
                        <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">Tipo entrega</th>
                            <th scope="col">Fase</th>
                            <th scope="col">Semana Inicio</th>
                            <th scope="col">Cantidad Solicitada</th>
                            <th scope="col">Cantidad Inicio</th>
                            <th scope="col">Cálculo Multiplicación</th>
                            <th scope="col">Cálculo Enraizamiento</th>
                            <th scope="col">Cálculo Adaptado</th>
                            <th scope="col">Semana Despacho</th>
                            <th scope="col">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td>
                                <select CLASS="selectpicker" name="TpEntrega" id="TpEntrega">
                                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                    <option value="1">In vitro</option>
                                    <option value="2">Adaptado</option>
                                </select>
                            </td>
                            <td>
                                <select class="selectpicker" name="tpFase" id="tpFase">
                                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                    <option value="1">Germo</option>
                                    <option value="2">stock</option>
                                </select>
                            </td>

                            <td>
                                <input type="week" id="SemanaInicio" name="SemanaInicio">
                            </td>
                            <td>

                                <input type="text" id="CantidadSolicitada" name="CantidadSolicitada" size="5">
                            </td>
                            <td>
                                <input type="text" id="CantPLantas" name="CantPLantas" size="5">

                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>Ciclo Antes</td>
                                        <td>Ciclo Final</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="SemanaMultiplicacionUnoantes" name="SemanaMultiplicacionUnoantes" size="7" disabled>
                                            <input type="text" id="CantPlantasMultiplicacionUnoAntes" name="CantPlantasMultiplicacionUnoAntes" size="7" disabled>

                                        </td>
                                        <td>
                                            <input type="text" id="SemanaMultiplicacionUnoDespues" name="SemanaMultiplicacionUnoDespues" size="7" disabled>
                                            <input type="text" id="CantPlantasMultiplicacionUnoDespues" name="CantPlantasMultiplicacionUnoDespues" size="7" disabled>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <input type="text" id="SemanaEnra" name="SemanaEnra" size="7" disabled>
                                <input type="text" id="CantEnra" name="CantEnra" size="7" disabled>
                            </td>
                            <td>
                                <input type="text" id="Semanadapa" name="Semanadapa" size="7" disabled>
                                <input type="text" id="CantAdap" name="CantAdap" size="7" disabled>
                            </td>
                            <td>
                                <input type="text" id="SemanaDespa" name="SemanaDespa" size="7" disabled>
                            </td>
                            <td>
                                <a class="btn btn-success" onclick="CalcularPedidoProyeccion()" id="CalcularPedido">Calcular</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- regresion        -->

        <div class="card card-body col-lg-12" id="divRegrecion" style="display: none">
            <div class="text-center">
                <h3><STRONG> REGRESION</STRONG></h3>
            </div>
            <div class="row">
                <div class="row col-lg-12">
                    <div class="col-lg-3">
                        <label class=" col-form-label text-md-right">{{ __('Variedad') }}</label>
                        <select class="selectpicker" data-show-subtext="true" id="VariedadR" data-live-search="true">
                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                            @foreach($Variedades as $Variedad)
                                <option value="{{ $Variedad->id }}">{{ $Variedad->Codigo }} {{ $Variedad->Nombre_Variedad }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="DatosVisualesR" class="col-lg-9" style="display: none">
                        <div class="row col-lg-12">

                            <div class="col-lg-3">
                                <label class="col-form-label text-md-right">{{ __('Factor') }}</label>
                                <input id="FactorR" name="factorR"/>
                            </div>

                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Introducciones</h3>

                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-lg-12">
                                                <table id="TableIntroduccionesR" class="table table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Introducción</th>
                                                        <th>Semana Ultimo Mov</th>
                                                        <th>Fase</th>
                                                        <th>Cantidad Plantas</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-12" id="TablaSimulacionProyeccionR" style="display: none">
                    <hr style=" height: 1px;  background-color: #0b97c4;">
                    <table class="table table-sm">
                        <thead class="thead-dark text-center">
                        <tr>
                            <th scope="col">Tipo entrega</th>
                            <th scope="col">Semana Despacho</th>
                            <th scope="col">Cantidad Despachar</th>
                            <th scope="col">Cálculo Multiplicación</th>
                            <th scope="col">Cálculo Enraizamiento</th>
                            <th scope="col">Cálculo Adaptado</th>
                            <th scope="col">Semana Despacho</th>
                            <th scope="col">Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <td>
                                <select CLASS="selectpicker" name="TpEntregaR" id="TpEntregaR">
                                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                    <option value="1">In vitro</option>
                                    <option value="2">Adaptado</option>
                                </select>
                            </td>


                            <td>
                                <input type="week" id="SemanaDespachoR" name="SemanaDespachoR">
                            </td>
                            <td>

                                <input type="text" id="CantidadDespacharR" name="CantidadDespacharR" size="6">
                            </td>
                            <td>
                                <input type="text" id="InicioMultiplicacionR" name="InicioMultiplicacionR" size="7" disabled>
                                <input type="text" id="PlantasInicarR" name="PlantasInicarR" size="7" disabled>
                            </td>
                            <td>
                                <input type="text" id="SemanaEnraR" name="SemanaEnraR" size="7" disabled>
                                <input type="text" id="CantEnraR" name="CantEnraR" size="7" disabled>
                            </td>
                            <td>
                                <input type="text" id="SemanadapaR" name="SemanadapaR" size="7" disabled>
                                <input type="text" id="CantAdapR" name="CantAdapR" size="7" disabled>
                            </td>
                            <td>
                                <input type="text" id="SemanaDespaR" name="SemanaDespaR" size="7" disabled>
                            </td>
                            <td>
                                <a class="btn btn-success" onclick="CalcularPedidoProyeccionR()" id="CalcularPedidoR">Calcular</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>





    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

    <script>
        $(document).ready(function () {
            $('#divProyección').hide();
            $('#divRegrecion').hide();

            $('#TipoSimulacion').change(function () {
                let TipoSimulacion = $(this).val();
                if (TipoSimulacion === 1 || TipoSimulacion === '1') {
                    $('#divProyección').show();
                    $('#divRegrecion').hide();
                } else {
                    $('#divProyección').hide();
                    $('#divRegrecion').show();
                }
            });

            $('#Variedad').change(function () {
                let IdVariedad = $(this).val();
                let token = $('#token').val();
                Swal.fire({
                    icon: 'success',
                    title: 'Ojo...',
                    text: 'Revizar información tecnica de la variedad, los factores deben ir con PUNTO (.) y debe tener las semanas de cada fase diligenciadas',
                });
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: {IdVariedad: IdVariedad},//datos que envio
                    url: "{{ route('ConsultaIntroduccionesFactor') }}",
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result.consulta);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            //console.log(Result);

                            $('#Factor').val(Result.factor.CoeficienteMultiplicacion);
                            var tbHtml = '';
                            $.each(Result.identificadores, function (index, value) {

                                tbHtml += '<tr>' +
                                    '<td>' + value.Indentificador + '</td>' +
                                    '<td>' + value.SemanUltimoMovimiento + '</td>' +
                                    '<td>' + value.NombreFase + '</td>' +
                                    '<td>' + value.CantPlantas + '</td>' +
                                    '</tr>';

                                $('#DatosVisuales1').show();
                                $('#TablaSimulacionProyeccion').show();
                            });
                            $('#TableIntroducciones tbody').html(tbHtml);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Revizar Algo salio mal',
                            });
                        }
                    }
                });

            });

            $('#TpEntrega').change(function () {
                let Tpentrega = $(this).val();
                if (Tpentrega === 1 || Tpentrega === '1') {
                    $('#Semanadapa').hide();
                    $('#CantAdap').hide();
                } else {
                    $('#Semanadapa').show();
                    $('#CantAdap').show();
                }
            });

            $('#TpEntregaR').change(function () {
                let Tpentrega = $(this).val();
                if (Tpentrega === 1 || Tpentrega === '1') {
                    $('#SemanadapaR').hide();
                    $('#CantAdapR').hide();
                } else {
                    $('#SemanadapaR').show();
                    $('#CantAdapR').show();
                }
            });

            $('#SemanaDespachoR').change(function () {
                let Semana = $('#SemanaDespachoR').val();

                var separador = "-W",
                    arregloDeSubCadenas = Semana.split(separador)[0],
                    arregloDeSubCadenass = Semana.split(separador)[1];

                let Fecha = arregloDeSubCadenas + '' + arregloDeSubCadenass;


                $('#SemanaDespaR').val(Fecha);
            });


            $('#VariedadR').change(function () {
                let IdVariedadR = $(this).val();
                let token = $('#token').val();
                Swal.fire({
                    icon: 'success',
                    title: 'Ojo...',
                    text: 'Revizar información tecnica de la variedad, los factores deben ir con PUNTO (.) y debe tener las semanas de cada fase diligenciadas',
                });
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: {IdVariedad: IdVariedadR},//datos que envio
                    url: "{{ route('ConsultaIntroduccionesFactor') }}",
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        //console.log(Result.consulta);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            //console.log(Result);

                            $('#FactorR').val(Result.factor.CoeficienteMultiplicacion);
                            var tbHtml = '';
                            $.each(Result.identificadores, function (index, value) {

                                tbHtml += '<tr>' +
                                    '<td>' + value.Indentificador + '</td>' +
                                    '<td>' + value.SemanUltimoMovimiento + '</td>' +
                                    '<td>' + value.NombreFase + '</td>' +
                                    '<td>' + value.CantPlantas + '</td>' +
                                    '</tr>';

                                $('#DatosVisualesR').show();
                                $('#TablaSimulacionProyeccionR').show();
                            });
                            $('#TableIntroduccionesR tbody').html(tbHtml);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Revizar Algo salio mal',
                            });
                        }
                    }
                });

            });
        });

        function CalcularPedidoProyeccion() {
            let token = $('#token').val();
            let IdVariedad = $('#Variedad').val();
            let Factor = $('#Factor').val();
            let Tpentrega = $('#TpEntrega').val();
            let tpFase = $('#tpFase').val();
            let CantPLantas = $('#CantPLantas').val();
            let SemanaInicio = $('#SemanaInicio').val();
            let CantidadSolicitada = $('#CantidadSolicitada').val();



            if (SemanaInicio === '' || CantPLantas === '' || CantidadSolicitada === '' || Tpentrega === null || tpFase === null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe Diligenciar Todos los datos ',
                });

            } /*else if (CantidadSolicitada < CantPLantas ) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en las cantidades digitadas verifique',
                });
            }*/ else {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {
                        IdVariedad: IdVariedad,
                        Factor: Factor,
                        Tpentrega: Tpentrega,
                        tpFase: tpFase,
                        CantPLantas: CantPLantas,
                        SemanaInicio: SemanaInicio,
                        CantidadSolicitada: CantidadSolicitada,
                    },
                    type: 'post',
                    dataType: 'json',
                    url: '{{ route('CalcularSimulacionPedido')}}',
                    success: function (Result) {
                        if (Result.data === 1) {
                            /*uno antes*/

                            $('#SemanaMultiplicacionUnoantes').val(Result.SemanaMultiplicacionAntes);
                            $('#CantPlantasMultiplicacionUnoAntes').val(Result.CantidadPlantasMultiplicacion);
                            $('#SemanaMultiplicacionUnoDespues').val(Result.SemanaMultiplicacion);
                            $('#CantPlantasMultiplicacionUnoDespues').val(Result.CantidadPlantasMultiplicacionM);
                            $('#SemanaEnra').val(Result.SemanaEnraizamiento);
                            $('#CantEnra').val(Result.PlanttasEnreiazar);
                            $('#Semanadapa').val(Result.SemanaAdaptacion);
                            $('#CantAdap').val(Result.CantidadAdaptacion);
                            $('#SemanaDespa').val(Result.SEmanaDespacho);
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

        function CalcularPedidoProyeccionR() {
            let token = $('#token').val();
            let IdVariedadR = $('#VariedadR').val();
            let FactorR = $('#FactorR').val();
            let TpentregaR = $('#TpEntregaR').val();
            let SemanaDespachoR = $('#SemanaDespachoR').val();
            let CantidadDespacharR = $('#CantidadDespacharR').val();


            if (FactorR === '' || TpentregaR === null || SemanaDespachoR === '' || CantidadDespacharR === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe Diligenciar Todos los datos ',
                });

            } else {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {
                        IdVariedadR: IdVariedadR,
                        FactorR: FactorR,
                        TpentregaR: TpentregaR,
                        SemanaDespachoR: SemanaDespachoR,
                        CantidadDespacharR: CantidadDespacharR,
                    },
                    type: 'post',
                    dataType: 'json',
                    url: '{{ route('ProyeccionRegresion')}}',
                    success: function (Result) {
                        if (Result.data === 1) {
                           // console.log(Result);
                            /*uno antes*/
                            $('#InicioMultiplicacionR').val(Result.SemanaMultiplicacion);
                            $('#PlantasInicarR').val(Result.CantidadMultplicar);
                            $('#SemanaEnraR').val(Result.SemanaEnraizamiento);
                            $('#CantEnraR').val(Result.PlanttasEnreiazar);
                            $('#SemanadapaR').val(Result.SemanaAdaptacion);
                            $('#CantAdapR').val(Result.CantidadAdaptacion);

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
