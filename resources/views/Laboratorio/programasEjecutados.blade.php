@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <div style="display: flex; justify-content:center; align-items: flex-end;">
            <h2><i class="fa fa-line-chart"></i> Reporte Programas</h2>
        </div>

        <div class="box-body" style="margin-top: -10px">

            <ul class="nav nav-tabs  nav-justified">
                <li>
                    <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ProgramasUltimaSemana">Programas Ultima Semana</a></li>
                <li><a class="nav-link" id="contact-tab" data-toggle="tab" role="tab" aria-controls="contact" aria-selected="false" href="#ProgramasPorFechas">Programas Semana Actual</a></li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" id="ProgramasUltimaSemana">
                    <div class="container-fluid">
                        <div style="margin-left: 10px">
                            <label>Buscar</label>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 350px;">
                                    <input type="text" id="search" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--<input type="text" id="search" placeholder="Escribe para buscar..."/>--}}
                        <div class="form-row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <h5 class="card-header text-center">Salidas</h5>
                                    <div class="card-body">
                                        <div class="table table-responsive">
                                            <table id="TableProgramasSemanalSalidas" class="" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Variedad</th>
                                                    <th>Genero</th>
                                                    <th>Identificador</th>
                                                    <th>Fase</th>
                                                    <th>Sem Despacho</th>
                                                    <th>Cliente</th>
                                                    <th># Plantas</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach( $ProgramasEjecutadosSalidasWeekPA as $ProgramasEjecutadosSalidasWeekPAs )
                                                    <tr>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->Codigo }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->Nombre_Variedad }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->NombreGenero }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->Indentificador }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->NombreFase }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->SemanaDespacho }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->cliente }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekPAs->CantPlantasSalidas }} </td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <h5 class="card-header text-center">Entradas</h5>
                                    <div class="card-body">
                                        <div class="table table-responsive">
                                            <table id="TableProgramasSemanalEntradas" class="display nowrap col-md-12 col-lg-12 col-xl-12 cell-border" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th> Variedad</th>
                                                    <th>Genero</th>
                                                    <th>Identificador</th>
                                                    <th>Fase</th>
                                                    <th>Sem Despacho</th>
                                                    <th>Cliente</th>
                                                    <th># Plantas</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach( $ProgramasEjecutadosEntradasWeekPA as $ProgramasEjecutadosEntradasWeekPAs )
                                                    <tr>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->Codigo }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->Nombre_Variedad }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->NombreGenero }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->Indentificador }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->NombreFase }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->SemanaDespacho }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->cliente }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekPAs->CantPlantasSalidas }} </td>

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
                <div class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab" id="ProgramasPorFechas">
                    <div class="container-fluid">
                        <div style="margin-left: 10px">
                            <label>Buscar</label>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 350px;">
                                    <input type="text" id="searchA" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="col-lg-6">
                                <div class="card">
                                    <h5 class="card-header text-center">Salidas</h5>
                                    <div class="card-body">
                                        <div class="table table-responsive">
                                            <table id="TableProgramasSemanalSalidasActuales" class="display nowrap col-md-12 col-lg-12 col-xl-12 cell-border" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>Codigo Variedad</th>
                                                    <th>Nombre Variedad</th>
                                                    <th>Genero</th>
                                                    <th>Identificador</th>
                                                    <th>Fase</th>
                                                    <th>Semana Despacho</th>
                                                    <th>Cliente</th>
                                                    <th># Plantas</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach( $ProgramasEjecutadosSalidasWeekAC as $ProgramasEjecutadosSalidasWeekACs )
                                                    <tr>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->Codigo }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->Nombre_Variedad }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->NombreGenero }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->Indentificador }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->NombreFase }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->SemanaDespacho }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->cliente }} </td>
                                                        <td> {{ $ProgramasEjecutadosSalidasWeekACs->CantPlantasSalidas }} </td>

                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <h5 class="card-header text-center">Entradas</h5>
                                    <div class="card-body">
                                        <div class="table table-responsive">
                                            <table id="TableProgramasSemanalEntradasActuales" class="display nowrap col-md-12 col-lg-12 col-xl-12 cell-border" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th> Variedad</th>
                                                    <th>Genero</th>
                                                    <th>Identificador</th>
                                                    <th>Fase</th>
                                                    <th>Sem Despacho</th>
                                                    <th>Cliente</th>
                                                    <th># Plantas</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach( $ProgramasEjecutadosEntradasWeekAC as $ProgramasEjecutadosEntradasWeekACs )
                                                    <tr>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->Codigo }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->Nombre_Variedad }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->NombreGenero }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->Indentificador }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->NombreFase }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->SemanaDespacho }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->cliente }} </td>
                                                        <td> {{ $ProgramasEjecutadosEntradasWeekACs->CantPlantasSalidas }} </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <div class="col-lg-6">

                                 <div class="col-lg-12" style="text-align: center"><h3>Entradas</h3></div>

                                 <div class="table table-responsive">
                                     <table id="TableProgramasSemanalEntradasActuales" class="display nowrap col-md-12 col-lg-12 col-xl-12 cell-border" style="width:100%;">
                                         <thead>
                                         <tr>
                                             <th>Codigo</th>
                                             <th> Variedad</th>
                                             <th>Genero</th>
                                             <th>Identificador</th>
                                             <th>Fase</th>
                                             <th>Sem Despacho</th>
                                             <th>Cliente</th>
                                             <th># Plantas</th>
                                         </tr>
                                         </thead>
                                         <tbody>

                                         @foreach( $ProgramasEjecutadosEntradasWeekAC as $ProgramasEjecutadosEntradasWeekACs )
                                             <tr>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->Codigo }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->Nombre_Variedad }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->NombreGenero }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->Indentificador }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->NombreFase }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->SemanaDespacho }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->cliente }} </td>
                                                 <td> {{ $ProgramasEjecutadosEntradasWeekACs->CantPlantasSalidas }} </td>

                                             </tr>
                                         @endforeach


                                         </tbody>
                                     </table>
                                 </div>

                             </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#TableProgramasSemanalSalidas, #TableProgramasSemanalEntradas,#TableProgramasSemanalSalidasActuales,#TableProgramasSemanalEntradasActuales').dataTable({
                dom: "Bfrtip",
                paging: false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_,  _TOTAL_ Registros",
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


            $("#search").keyup(function () {
                _this = this;
                // Muestra los tr que concuerdan con la busqueda, y oculta los demás.
                $.each($("#TableProgramasSemanalSalidas tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
                $.each($("#TableProgramasSemanalEntradas tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });

            });
            $("#searchA").keyup(function () {
                _this = this;
                // Muestra los tr que concuerdan con la busqueda, y oculta los demás.
                $.each($("#TableProgramasSemanalSalidasActuales tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
                $.each($("#TableProgramasSemanalEntradasActuales tbody tr"), function () {
                    if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });

            });
        })

    </script>

@endsection
