<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gestión de Reporte Propiedades
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="btn-nuevo">
        <button class="btn btn-info" data-toggle="modal" data-target="#modal-nuevo"> Nuevo Registro</button>
    </div><br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Propiedades</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="tabla-reporte_propiedades">

                <?= $reporte_propiedades ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- ./box-body -->

        <!-- /.box-footer -->
    </div>
</section>
<!-- /.content -->



<!-- MODAL NUEVO -->

<div id="modal-nuevo" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-nuevo">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo Registro</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Propiedades</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Registro</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_registro" type="text" class="form-control datepicker" placeholder="31/05/2017" required="">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Nombre Propiedad</p>
                            <input type="text" class="form-control" name="rental" placeholder="Rental..." required="">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Rol</p>
                            <input type="text" class="form-control" name="rol" placeholder="Rol..." required=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Antecedentes Legales</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Compra</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_compra" type="text" class="form-control" placeholder="31/05/2017">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Folio</p>
                            <input type="text" name="folio" class="form-control" placeholder="Folio..."/>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Notaria</p>
                            <input type="text" name="notaria" class="form-control" placeholder="Notaria..."/>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <h3>Antecedentes Comerciales</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Deuda UF</p>
                            <input type="text" class="form-control solo-numeros" name="deuda_uf" placeholder="Deuda UF"/>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Banco</p>
                            <input type="text" name="banco" class="form-control" placeholder="Banco...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Dividendo</p>
                            <input type="text" name="dividendo" class="form-control" placeholder="Dividendo...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Monto UF</p>
                            <input type="text" name="monto_uf" class="form-control solo-numeros" placeholder="Monto UF...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Vencimiento</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_vencimiento" type="text" class="form-control datepicker" placeholder="31/05/2017" >
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL NUEVO -->

<!-- MODAL EDITAR -->
<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Registro</h4>
                </div>
                <div class="modal-body">
                    <input id="e-id" name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Propiedades</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Registro</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_registro" id="e-fecha_registro" type="text" class="form-control datepicker" placeholder="31/05/2017" required="">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Nombre Propiedad</p>
                            <input type="text" class="form-control" name="rental" id="e-rental" placeholder="Rental..." required="">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Rol</p>
                            <input type="text" class="form-control" name="rol" id="e-rol" placeholder="Rol..." required=""/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Antecedentes Legales</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Compra</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_compra" id="e-fecha_compra" type="text" class="form-control datepicker" placeholder="31/05/2017">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Folio</p>
                            <input type="text" name="folio" id="e-folio" class="form-control" placeholder="Folio..."/>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Notaria</p>
                            <input type="text" name="notaria" id="e-notaria" class="form-control" placeholder="Notaria..."/>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12">
                            <h3>Antecedentes Comerciales</h3>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Deuda UF</p>
                            <input type="text" class="form-control solo-numeros" name="deuda_uf" id="e-deuda_uf" placeholder="Deuda UF"/>
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Banco</p>
                            <input type="text" name="banco" id="e-banco" class="form-control" placeholder="Banco...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Dividendo</p>
                            <input type="text" name="dividendo" id="e-dividendo" class="form-control" placeholder="Dividendo...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Monto UF</p>
                            <input type="text" name="monto_uf" id="e-monto_uf" class="form-control solo-numeros" placeholder="Monto UF...">
                        </div>
                    </div>
                    <div class="row margin-5">
                        <div class="col-md-12">
                            <p>Fecha Vencimiento</p>
                            <input data-date-format="dd/mm/yyyy" name="fecha_vencimiento" id="e-fecha_vencimiento" type="text" class="form-control datepicker" placeholder="31/05/2017" >
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Registro</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL EDITAR -->
<div id="modal-vm" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ver Mas</h4>
                </div>
                <div class="modal-body">

                    <div class="row margin-5">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Propiedades</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Fecha Registro</th>
                                            <th>Nombre Propiedad</th>
                                            <th>Rol</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><p class="vm-clean" id="vm-fecha_registro"></p></td>
                                                <td><p class="vm-clean"  id="vm-rental"></p></td>
                                                <td><p class="vm-clean"  id="vm-rol"></p></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- ./box-body -->

                                <!-- /.box-footer -->
                            </div>
                        </div>

                    </div>

                    <div class="row margin-5">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Antecedentes Legales</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <th>Fecha Compra</th>
                                        <th>Folio</th>
                                        <th>Notaria</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><p class="vm-clean"  id="vm-fecha_compra"></p></td>
                                            <td><p class="vm-clean"  id="mv-folio"></p></td>
                                            <td><p class="vm-clean"  class="vm-notaria"></p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- ./box-body -->

                                <!-- /.box-footer -->
                            </div>
                        </div>

                    </div>

                    <div class="row margin-5">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Antecedentes Comerciales</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <th>Deuda UF</th>
                                            <th>Banco</th>
                                            <th>Dividendo</th>
                                            <th>Monto UF</th>
                                            <th>Fecha Vencimiento</th>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><p class="vm-clean"  id="vm-deuda_uf"></p></td>
                                            <td><p class="vm-clean"  id="vm-banco"></p></td>
                                            <td><p id="vm-dividendo"></p></td>
                                            <td><p class="vm-clean"  id="vm-monto_uf"></p></td>
                                            <td><p class="vm-clean"  id="vm-fecha_vencimiento"></p></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!-- /.row -->
                                </div>
                                <!-- ./box-body -->

                                <!-- /.box-footer -->
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
