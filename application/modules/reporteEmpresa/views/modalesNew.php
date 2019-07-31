

<!-- Modal  Nuevo Transaccion y compromiso -->

<div class="modal fade" id="nueva-transaccion-y-compromisol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-nueva-transaccion-compromiso">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nueva Transacción y Compromiso</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="descripcion" id="descripcion" class="form-control">
                            <option value="" selected disabled>Escoja una descripción</option>
                            <option value="1">Ingreso</option>
                            <option value="2">Egreso</option>
                            <option value="3">Compromiso Ingreso</option>
                            <option value="4">Compromiso Egreso</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="origen" name="origen">
                            <option value="" selected disabled>Escoja un origen</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="destino" name="destino">
                            <option value="" selected disabled>Escoja un destino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control solo-numeros " name="monto" id="monto" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control " name="fecha-realizacion" id="fecha-realizacion" type="text">
                    </div>
                    <div class="form-group">
                        <input class="form-control " name="fecha-limite" id="fecha-limite" type="text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div> 
</div>