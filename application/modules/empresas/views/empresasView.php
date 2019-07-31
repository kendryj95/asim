<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gestión de Empresas
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <button class="btn btn-info" id="btn-nuevo-registro"><span class="glyphicon glyphicon-plus-sign"></span> Nuevo Registro </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Empresas</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="tabla-empresas">
                        <?= $empresas ?>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->

                <!-- /.box-footer -->
            </div>

        </div>
    </div>

</section>
<!-- /.content -->



<!-- Modal -->
<div class="modal fade" id="modal-nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <form id="form-nuevo">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Escriba un nombre de empresa..." name="empresa" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Escriba un porcentaje participacion..." name="participacion">
                    </div>
                    <div class="form-group">
                        <p>Inversor</p>
                        <select name="inversor" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Es esta una empresa de papel?</p>
                        <select name="ghost" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Empresa Padre</p>
                        <select name="parent_id" id="parent_id" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Comentario de Reporte de Empresa</p>
                        <textarea name="comentario_reporte_empresa" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <p>Comentario de Reporte de Inversión</p>
                        <textarea name="comentario_reporte_inversion" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- MODAL NUEVO USUARIO -->

<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Empresa</h4>

                </div>

                <div class="modal-body">
                    <input type="hidden" id="e-id" name="id">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Escriba un nombre..." name="empresa" id="e-empresa" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Escriba un porcentaje participacion..." name="participacion" id="e-participacion">
                    </div>
                    <div class="form-group">
                        <p>Inversor</p>
                        <select name="inversor" id="e-inversor" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Es esta una empresa de papel?</p>
                        <select name="ghost" id="e-ghost" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Empresa Padre</p>
                        <select name="parent_id" id="e-parent_id" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <p>Comentario de Reporte de Empresa</p>
                        <textarea name="comentario_reporte_empresa" id="e-comentario_reporte_empresa" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <p>Comentario de Reporte de Inversión</p>
                        <textarea name="comentario_reporte_inversion" id="e-comentario_reporte_inversion" class="form-control"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL NUEVO USUARIO -->