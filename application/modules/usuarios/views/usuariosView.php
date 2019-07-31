<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Gestión de Usuarios
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="btn-nuevo">
        <button class="btn btn-info" data-toggle="modal" data-target="#modal-nuevo"> Nuevo Usuario</button>
    </div><br>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Usuarios</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="tabla-usuarios">
                <?= $usuarios ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- ./box-body -->

        <!-- /.box-footer -->
    </div>

</section>
<!-- /.content -->



<!-- MODAL NUEVO USUARIO -->

<div id="modal-nuevo" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-nuevo">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Nuevo Usuario</h4>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Escriba un nombre..." name="nombre" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Escriba un email..." name="email" required>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="tipo" id="tipo">
                                <option value="" selected disabled>Seleccione un tipo de usuario</option>
                                <option value="1">Gerente/ administrador</option>
                                <option value="2">Usuario/ digitador</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Escriba una contraseña..." name="password" id="pass-n" required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Repita la contraseña..." name="password2" id="pass2-n" required>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL NUEVO USUARIO -->


<!-- MODAL NUEVO USUARIO -->

<div id="modal-edit" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-edit">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="e-id" name="id">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Escriba un nombre..." name="nombre" id="e-nombre" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="Escriba un email..." name="email" id="e-email" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="tipo" id="e-tipo">
                            <option value="1">Gerente/ administrador</option>
                            <option value="2">Usuario/ digitador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Escriba una contraseña..." name="password" id="e-pass-n">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Repita la contraseña..." name="password2" id="e-pass2-n">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL NUEVO USUARIO -->



<!-- MODAL ADMINISTRAR PERMISOS -->

<div id="modal-permisos" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form id="form-permisos">

            <input type="hidden" name="id_user" id="id_user"/>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Administrar Permisos</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="col-md-10">
                            <select class="form-control" name="empresas_disponibles" id="empresas_disponibles" required></select>
                        </div>
                        <div class="col-md-1">
                            <button id="btn-asignar-empresa" class="btn btn-primary" type="submit">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Empresas actualmente asignadas a este usuario</h4>
                            <div id="empresas-asignadas-modal">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">salir</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- MODAL ADMINISTRAR PERMISOS -->