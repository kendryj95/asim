<!-- Content Header (Page header) -->
<section class="content-header text-center">
    <h1 style="font-size: 28px;">
        REPORTE DE INVERSIÓN
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="nombre_empresa">
                <b><h3 style="font-weight: 700;"><?= $empresa->empresa ?></h3></b>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Registro</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <select id="years_id" style="margin-top: 5px;margin-bottom: 5px;" class="form-control">
                <?= $years ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div id="accordion-registros">
                <!-- AQUI COMIENZA ACORDEON -->
                <?php if($registros == ''){
                    echo '<b>No se encontraron registros!</b>';
                }else{
                    echo $registros;
                } ?>
                <!-- AQUI TERMINA ACORDEON -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b><h4>COMENTARIOS</h4></b><br>
                    <textarea class="form-control" name="" id="comentario" ><?= $empresa->comentario_reporte_inversion ?></textarea><br>
                    <div class="text-right">
                        <button id="btn-comentario" class="btn btn-info">Guardar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- /.content -->



<!-- MODAL NUEVO REGISTRO DE INVERSION -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="form-nuevo-registro-inversion">
            <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?= $empresa->id ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Nuevo Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-3">
                            <b>Fecha</b>
                        </div>
                        <div class="col-md-3">
                            <b>Detalle Glosa</b>
                        </div>
                        <div class="col-md-3">
                            <b>Tipo</b>
                        </div>
                        <div class="col-md-3">
                            <b>Monto</b>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control fc-clean datepicker" type="text" name="fecha1" required>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control fc-clean" type="text" name="detalle_glosa1" placeholder="Ingrese detalle.." required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control fc-b1" name="tipo1">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control fc-clean solo-numeros" type="text" name="monto1" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control fc-clean datepicker" type="text" name="fecha2">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="detalle_glosa2" value="CM" required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control fc-b1" name="tipo2">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control fc-clean solo-numeros" type="text" name="monto2">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control fc-clean datepicker" type="text" name="fecha3">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" name="detalle_glosa3" value="SALDO" required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control fc-b1" name="tipo3">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control fc-clean solo-numeros" type="text" name="monto3">
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

 <!-- ###################################################################################################################
  ####################################################################################################################
   ################################################################################################################### -->

<!-- MODAL NUEVO REGISTRO DE INVERSION -->


<!-- Modal -->
<div class="modal fade" id="myModal-editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <form id="form-editar-registro-inversion">
            <input type="hidden" name="idEmpresa" value="<?= $empresa->id ?>">
            <input type="hidden" name="idReporte" id="e-idReporte">
            <input type="hidden" name="id1" id="e-id1">
            <input type="hidden" name="id2" id="e-id2">
            <input type="hidden" name="id3" id="e-id3">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Editar Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-3">
                            <b>Fecha</b>
                        </div>
                        <div class="col-md-3">
                            <b>Detalle Glosa</b>
                        </div>
                        <div class="col-md-3">
                            <b>Tipo</b>
                        </div>
                        <div class="col-md-3">
                            <b>Monto</b>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" id="e-fecha1" name="fecha1" required>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" id="e-detalle_glosa1" name="detalle_glosa1" placeholder="Ingrese detalle.." required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="e-tipo1" name="tipo1">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control solo-numeros" type="text" id="e-monto1" name="monto1" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" id="e-fecha2" name="fecha2">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" id="e-detalle_glosa2" name="detalle_glosa2" value="CM" required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="e-tipo2" name="tipo2">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control solo-numeros" type="text" id="e-monto2" name="monto2">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-3">
                            <input data-date-format="dd/mm/yyyy" class="form-control datepicker" type="text" id="e-fecha3" name="fecha3">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" type="text" id="e-detalle_glosa3" name="detalle_glosa3" value="SALDO" required>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="e-tipo3" name="tipo3">
                                <option value="1">ingreso</option>
                                <option value="2">egreso</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control solo-numeros" type="text" id="e-monto3" name="monto3">
                        </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>