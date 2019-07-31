
<!-- Modal -->
<div class="modal fade" id="modal-nueva-favor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-nueva-favor">
                <input type="hidden" name="id_empresa" value="<?= $empresa->id ?>"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>Favor</b>
                        <input class="form-control" type="text" name="favor" required="">
                    </div>
                    <div class="form-group">
                        <b>Fecha Emision</b>
                        <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" name="fecha_emision" required="">
                    </div>
                    <div class="form-group">
                        <b>Saldo</b>
                        <input class="form-control solo-numeros" type="text" name="saldo" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-editar-favor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-editar-favor">
                <input type="hidden" name="id" id="e-id-favor"/>
                <input type="hidden" name="id_empresa" value="<?= $empresa->id ?>"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>Favor</b>
                        <input class="form-control" type="text" name="favor" id="e-favor" required="">
                    </div>
                    <div class="form-group">
                        <b>Fecha Emision</b>
                        <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" name="fecha_emision" id="e-favor-fecha_emision" required="">
                    </div>
                    <div class="form-group">
                        <b>Saldo</b>
                        <input class="form-control solo-numeros" type="text" name="saldo" id="e-favor-saldo" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

