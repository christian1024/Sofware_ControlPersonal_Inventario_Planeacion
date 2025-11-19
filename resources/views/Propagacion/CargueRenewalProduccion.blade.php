@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="form-row">
            <div id="tabs" class="col-md-12 col-lg-12 col-xs-12 box box-body spaceTap" style="margin-top:10px;">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#CargueRenewall"><span>Cargue Excel Renewall</span></a></li>

                    <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#GenerarEtqRenewall"><span>Generar Etiquetas Renewall</span></a></li>


                </ul>

                <div class="tab-content" id="myTabContent">
                    <div id="CargueRenewall" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">

                        <div class="card card-body">
                            <div class="card">
                                <div class="card-header">
                                    <form id="" method="POST" action="{{ route('LoadInventoryRenewall') }}" enctype="multipart/form-data">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                        <div class="box box-default form-row">
                                            <div class="col-lg-4">
                                                <label>Importar Renewal</label>
                                                <input type="file" required name="Cargue_Renewal">
                                            </div>
                                            <div class="col-lg-6" style="margin: 20px">
                                                <button type="submit" class="btn btn-success"> {{ __('Cargar') }} </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                                <div class="card card-body">
                                    <div class="table table-responsive">
                                        <table class="table table-hover " id="TableLoadInventory">
                                            <thead class="table-info">
                                            <tr>
                                                <th>Semana</th>
                                                <th>Fecha</th>
                                                <th>PlotID Nuevo</th>
                                                <th>PlotID Origen</th>
                                                <th>Codigo Variedad</th>
                                                <th>Nombre Variedad</th>
                                                <th>Cantidad</th>
                                                <th>Cantidad Bolsillos</th>
                                                <th>Bloque</th>
                                                <th>Nave</th>
                                                <th>Cama</th>
                                                <th>Procedencia</th>
                                                <th>Semana Cosecha</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($Renewal as $Columnas)
                                                <tr>
                                                    <td>{{ $Columnas->Semana }}</td>
                                                    <td>{{ $Columnas->Fecha }}</td>
                                                    <td>{{ $Columnas->PlotIDNuevo }}</td>
                                                    <td>{{ $Columnas->PlotIDOrigen }}</td>
                                                    <td>{{ $Columnas->CodigoIntegracion }}</td>
                                                    <td>{{ $Columnas->NombreVariedad }}</td>
                                                    <td>{{ $Columnas->Cantidad }}</td>
                                                    <td>{{ $Columnas->CantidadBolsillos }}</td>
                                                    <td>{{ $Columnas->Bloque }}</td>
                                                    <td>{{ $Columnas->Nave }}</td>
                                                    <td>{{ $Columnas->Cama }}</td>
                                                    <td>{{ $Columnas->Procedencia }}</td>
                                                    <td>{{ $Columnas->SemanaCosecha }}</td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="GenerarEtqRenewall" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card card-body">
                            <div class="card">
                                <div class="card-header">
                                    <form action="{{ route('GenerarEtiquetasRenewal') }}" method="post">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                        <div class="">
                                            <button id="btnDistribuir" type="submit" class="btn btn-primary" style="margin-left: 20px"><i class="fa fa-cube"></i> Distribucion Renewall</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="TableLoadInventory">
                                            <thead class="table-info">
                                            <tr>
                                                <th>Semana Cosecha</th>
                                                <th>Fecha</th>
                                                <th>PlotID Nuevo</th>
                                                <th>PlotID Origen</th>
                                                <th>Codigo Variedad</th>
                                                <th>Variedad</th>
                                                <th>Cantidad Esquejes</th>
                                                <th>Cantidad Bolsillos</th>
                                                <th>Localizacion</th>
                                                <th>Procedencia</th>
                                                <th>Caja</th>
                                                <th>Codigo Barras Caja</th>
                                                <th>Semana Entrega</th>
                                                <th>Codigo Barras</th>
                                                <th>Esquejes Por Bolsillo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($EtiquetasGeneradas as $Columnas)
                                                <tr>
                                                    <td>{{ $Columnas->SemanaActual }}</td>
                                                    <td>{{ $Columnas->Fecha }}</td>
                                                    <td>{{ $Columnas->PlotIDNuevo }}</td>
                                                    <td>{{ $Columnas->PlotIDOrigen }}</td>
                                                    <td>{{ $Columnas->CodigoIntegracion }}</td>
                                                    <td>{{ $Columnas->NombreVariedad }}</td>
                                                    <td>{{ $Columnas->Cantidad }}</td>
                                                    <td>{{ $Columnas->CantidadBolsillos }}</td>
                                                    <td>{{ $Columnas->Localizacion }}</td>
                                                    <td>{{ $Columnas->ProcedenciaInv }}</td>
                                                    <td>{{ $Columnas->Caja }}</td>
                                                    <td>{{ $Columnas->CodigoBarrasCaja }}</td>
                                                    <td>{{ $Columnas->SemanaCosecha }}</td>
                                                    <td>{{ $Columnas->CodigoBarras }}</td>
                                                    <td>{{ $Columnas->EsquejesXBolsillo }}</td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('#TableDistribucion, #TableLoadInventory').DataTable({

            dom: "Bfrtip",
            paging: true,
            "ordering": false,
            "language": {
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                "Previous": "Anterior",
            },

            buttons: [
                {
                    extend: 'excelHtml5',

                    text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                    titleAttr: 'Excel',
                    title: 'EtiquetasRenewal',
                    customize: function (xlsx) {
                        var sheet = xlsx.xl.worksheets['EtiquetasRenewal.xml'];
                        //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                    },

                },

            ],
        });
        @if(session()->has('Existente'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Hay Plots Repetidos verifique el archivo',
            });
        });
        @endif
    </script>
@endsection
