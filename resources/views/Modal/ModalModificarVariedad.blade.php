<div class="modal fade" id="ModificarVariedad" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i class="" style="color: #0b97c4"></i> Modificar Variedad</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updatevariedad') }}" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div class="">

                        <div class="col-lg-12">


                            <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Variedad') }}</label>
                            <input id="Nombre_VariedadM" type="text" autocomplete="off" class="form-control labelform " name="Nombre_VariedadMo" autofocus required>


                            <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Codigo') }}</label>
                            <input id="CodigoM" type="number" class="form-control labelform" name="Codigo_Mo" disabled required autofocus>
                            <input id="CodigoMo" type="hidden" class="form-control labelform" name="CodigoMo" required autofocus>


                            <label for="IdGenerosM" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                            <select id="IdGenerosM" class="form-control labelform" name="IdGenerosM" required>
                                <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>
                                @foreach($Generos as $Genero)
                                    <option value="{{ $Genero->id }}" {{--{{ ($EmpleadosLab && $EmpleadosLab->id_Sub_Area== $SubArea->id)?'selected':''}}--}}>  {{$Genero->NombreGenero}} </option>
                                @endforeach
                            </select>


                            <label for="IDEspecie" class="col-form-label text-md-right">{{ __('Nombre Especie') }}</label>
                            <select id="IDEspecie" class="form-control labelform" name="IDEspecie" required>

                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Modifica</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


