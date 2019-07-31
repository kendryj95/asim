

<!-- Modal -->
<div class="modal fade" id="modal-nueva-contra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-nueva-contra">
                <input type="hidden" name="id_empresa" value="<?= $empresa->id ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>Contra</b>
                        <input class="form-control" type="text" name="contra" required="">
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
<div class="modal fade" id="modal-editar-contra" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-editar-contra">
                <input type="hidden" name="id" id="e-id-contra"/>
                <input type="hidden" name="id_empresa" value="<?= $empresa->id ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>Contra</b>
                        <input class="form-control" type="text" name="contra" id="e-contra" required="">
                    </div>
                    <div class="form-group">
                        <b>Fecha Emision</b>
                        <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" name="fecha_emision" id="e-contra-fecha_emision" required="">
                    </div>
                    <div class="form-group">
                        <b>Saldo</b>
                        <input class="form-control solo-numeros" type="text" name="saldo" id="e-contra-saldo" required="">
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