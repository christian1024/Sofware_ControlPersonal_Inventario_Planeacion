<!--<div class="modal fade"  role="dialog">
    <div class="modal-dialog">-->
<div class="modal fade bd-example-modal-lg" id="creartickest" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="text-center">
                    <h3 class="modal-title"><i class="fa fa-cogs" aria-hidden="true"></i> Nuevo soporte</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('newTickets') }}" method="post">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <div class="">

                        <div class="col-lg-12">


                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Breve Descripción</label>
                                <div class="col-sm-9">
                                    <input type="text" required class="form-control" name="Descripcion" id="inputEmail3" placeholder="Error o Nuevo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" required class="col-sm-3 col-form-label">Tipo de solicitud</label>
                                <div class="col-sm-9">
                                    <select class="selectpicker" name="TipoSolicitud">
                                        <option>Incidente</option>
                                        <option>Solicitud</option>
                                    </select>
                                    <br>
                                    <span class="ms-metadata"><font style="vertical-align: inherit;">
                                            <font style="vertical-align: inherit;">El incidente es un problema de producción. </font></font><br>
                                            <font style="vertical-align: inherit;"><font style="vertical-align: inherit;">La solicitud es una nueva característica o mejora.</font>
                                        </font>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label">Justificación</label>
                                <div class="col-sm-9">
                                    <i class="fas fa-pencil-alt prefix"></i>
                                    <textarea id="form10" class="md-textarea form-control" name="Jusificacion" required maxlength="350" placeholder="Maximo 350 caracteres" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


