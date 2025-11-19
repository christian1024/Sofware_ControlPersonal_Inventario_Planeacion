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

    <div class="box-body">
        <div class="col-lg-12">
            <h3>Cargar Inventario</h3>
        </div>
        <form id="" method="POST" action="{{ route('LoadInventory') }}" enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

            <div class="box box-body col-lg-12">
                <div class="col-lg-4">
                    <label>Importar inventario</label>
                    <input type="file" required name="ImportInventory">
                </div>
                <div class="col-lg-6">
                    <button type="submit" style="margin-top: 10px" class="btn btn-success"> {{ __('Cargar') }} </button>
                </div>
            </div>
            <hr>
            <div class="table" style="height: 200px; margin-top: 10px;">
                <table class="" id="TableLoadInventory" style="width:100%">
                    <thead>
                    <tr>
                        {{--<th class="text-center">item</th>--}}
                        <th class="text-center">Codigo Variedad</th>
                        <th class="text-center">Identificacion</th>
                        <th class="text-center">Breeder</th>
                        <th class="text-center">Fase Actual</th>
                        <th class="text-center">Semana Ult Movi</th>
                        <th class="text-center">Semana Ingreso</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Cuarto</th>
                        <th class="text-center">Estante</th>
                        <th class="text-center">Piso</th>
                        <th class="text-center">Frasco</th>
                        <th class="text-center">Semana Despacho</th>
                        <th class="text-center">Cliente</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($hoy as $TipoContenedor)
                        <tr>
                            <td>{{ $TipoContenedor->CodigoVariedad }}</td>
                            <td>{{ $TipoContenedor->Identificador }}</td>
                            <td>{{ $TipoContenedor->Breeder }}</td>
                            <td>{{ $TipoContenedor->FaseActual }}</td>
                            <td>{{ $TipoContenedor->SemanaUltimoMovimiento }}</td>
                            <td>{{ $TipoContenedor->SemanaIngreso }}</td>
                            <td>{{ $TipoContenedor->Cantidad }}</td>
                            <td>{{ $TipoContenedor->id_Cuarto }}</td>
                            <td>{{ $TipoContenedor->id_Estante }}</td>
                            <td>{{ $TipoContenedor->id_Nivel }}</td>
                            <td>{{ $TipoContenedor->id_Frasco }}</td>
                            <td>{{ $TipoContenedor->SemanaDespacho }}</td>
                            <td>{{ $TipoContenedor->cliente }}</td>


                        </tr>
                    @endforeach
                    {{--
                                        @if(isset($dato) && count($dato)>0)
                                            @for($i=0; $i<count($dato); $i++)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        <div class="form-group {!!(($dato[$i]['codigovariedad']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['codigovariedad'] }}" class="form-control " disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['identificador']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['identificador']}}" class="form-control " disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['breeder']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['breeder']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['faseactual']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['faseactual']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['semanaultimomovimiento']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['semanaultimomovimiento']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['semanaingreso']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['semanaingreso']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['cantidad']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['cantidad']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['id_cuarto']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['id_cuarto']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['id_estante']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['id_estante']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['id_nivel']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['id_nivel']}}" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['id_frasco']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['id_frasco']}}" name="id_frasco" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="form-group {!! (($dato[$i]['cliente']!=''))?'':'has-error' !!}">
                                                            <input value="{{ $dato[$i]['cliente']}}" name="cliente" class="form-control" disabled required>
                                                        </div>
                                                    </td>
                                                    --}}{{-- <td>{{ $arrss->autor }}</td>
                                                     <td>{{ $arrss->año }}</td>--}}{{--
                                                </tr>

                                            @endfor
                                        @endif--}}
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <script>

        TableLoadInventory = $('#TableLoadInventory').DataTable({
            "searching": false,
            "language": {
                /*"search": "Buscar:",*/
                "info": 'Total Activos _TOTAL_',// "Mostrando Página False, Registros Inactivos _TOTAL_",
                "paginate": {
                    "first": 'Primero',
                    "last": 'Ultimo',
                    "next": 'Siguiente',
                    "previous": 'Anterior',
                }
            },

            orderCellsTop: true,
            scrollX: true,
            iDisplayLength: 100,
            fixedHeader: true,


        });


    </script>
@endsection
