

<!-- Modal  Nuevo Transaccion y compromiso -->

<div class="modal fade" id="nueva-transaccion-y-compromisol" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-nueva-transaccion-compromiso">
                <input type="hidden" name="id_empresa" id="id_empresa" value="<?= $empresa->id ?>"/>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">REGISTRO DE TRANSACCIONES Y PRÉSTAMOS</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Descripción
                        <select name="descripcion" id="descripcion" class="form-control" required>
                            <option value="" selected disabled>Escoja una descripción</option>
                            <option value="1">Devolución Préstamo (Ingreso)</option>
                            <option value="2">Devolución Préstamo (Egreso)</option>
                            <option value="3">Ingreso Préstamo</option>
                            <option value="4">Préstamo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        Origen
                        <select class="form-control free-disabled" id="origen" name="origen" required>
                            <option value="" selected disabled>Escoja un origen</option>
                            <?= $listadoEmpresas ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Destino
                        <select class="form-control free-disabled" id="destino" name="destino" required>
                            <option value="" selected disabled>Escoja un destino</option>
                            <?= $listadoEmpresas ?>
                        </select>
                    </div>
                    <div class="form-group">
                        Monto
                        <input class="form-control solo-numeros" name="monto" id="monto" type="text" placeholder="Ingrese un monto..." required>
                    </div>
                    <div class="form-group">
                        Fecha de Realización
                        <input placeholder="10/09/2017" data-date-format="dd/mm/yyyy" class="form-control datepicker" name="fecha-realizacion" id="fecha-realizacion" type="text" required >
                    </div>
                    <div class="form-group fecha-limite-div">
                        Fecha Limite
                        <input placeholder="10/09/2017" data-date-format="dd/mm/yyyy" class="form-control datepicker" name="fecha-limite" id="fecha-limite" type="text">
                    </div>
                    <div class="form-group" id="alertaNuevo" style="display: none;">
                        <div class="alert alert-warning" role="alert">Alerta! la fecha limite debe ser igual o mayor a la fecha de realización!</div>
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



<!-- Modal  ditar Transaccion y compromiso -->

<div class="modal fade" id="editar-transaccion-y-compromiso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form-editar-transaccion-compromiso">
                <input type="hidden" name="id_empresa" id="id_empresa" value="<?= $empresa->id ?>"/>
                <input type="hidden" id="e-id" name="id">
                <input type="hidden" id="e-par_id" name="par_id">
                <input type="hidden" id="e-descripcion_id" name="descripcion_id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">EDITAR REGISTRO DE TRANSACCIONES Y PRÉSTAMOS</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <b>Descripción</b>
                        <div id="e-registro_transaccion" class="clean"></div>
                    </div>
                    <div class="form-group">
                        <b>Descripción</b>
                        <div id="e-descripcion" class="clean"></div>
                    </div>
                    <div class="form-group">
                        <b>Origen</b>
                        <div id="e-origen" class="clean"></div>
                    </div>
                    <div class="form-group">
                        <b>Destino</b>
                        <div id="e-destino" class="clean"></div>
                    </div>
                    <div class="form-group">
                        <b>Monto</b>
                        <input class="form-control solo-numeros" name="monto" id="e-monto" type="text" placeholder="Ingrese un monto..." required>
                    </div>
                    <div class="form-group">
                        <b>Fecha de Realización</b>
                        <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="fecha-realizacion" id="e-fecha-realizacion" type="text" required>
                    </div>
                    <div id="e-fecha-limite-div" class="form-group">
                        <b>Fecha Limite</b>
                        <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="fecha-limite" id="e-fecha-limite" type="text">
                    </div>
                    <div class="form-group" id="alertaEditar" style="display: none;">
                        <div class="alert alert-warning" role="alert">Alerta! la fecha limite debe ser igual o mayor a la fecha de realización!</div>
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
<div class="modal fade" id="editar-balance-general" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="form-gb-editar">
            <input type="hidden" name="id" id="e-bg-id">
            <input type="hidden" name="id_empresa" id="e-bg-id_empresa">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Balance General</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <b>ACTIVOS</b>
                        </div>
                        <div class="col-md-4">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="activo_fecha" id="e-bg-activo_fecha" type="text" placeholder="10/09/2017">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control solo-numeros" name="activo_saldo" id="e-bg-activo_saldo" type="text" placeholder="Ingrese saldo..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>PASIVOS + PATRIMONIO</b>
                        </div>
                        <div class="col-md-4">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="pasivo_patrimonio_fecha" id="e-bg-pasivo_patrimonio_fecha" type="text">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control solo-numeros" name="pasivo_patrimonio_saldo" id="e-bg-pasivo_patrimonio_saldo" type="text" placeholder="Ingrese saldo..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>RESULTADO PERDIDA</b>
                        </div>
                        <div class="col-md-4">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="resultado_perdida_fecha" id="e-bg-resultado_perdida_fecha" type="text">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control solo-numeros-pos-neg" name="resultado_perdida_saldo" id="e-bg-resultado_perdida_saldo" type="text" placeholder="Ingrese saldo..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <b>RESULTADO GANANCIA</b>
                        </div>
                        <div class="col-md-4">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="resultado_ganancia_fecha" id="e-bg-resultado_ganancia_fecha" type="text">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control solo-numeros-pos-neg" name="resultado_ganancia_saldo" id="e-bg-resultado_ganancia_saldo" type="text" placeholder="Ingrese saldo..." required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><b>UTILIDAD</b></div>
                        <div class="col-md-4">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" name="utilidad_fecha" id="e-bg-utilidad_fecha" type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>