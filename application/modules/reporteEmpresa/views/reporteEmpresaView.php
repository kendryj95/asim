<!-- Content Header (Page header) -->
<section class="content-header text-center">
    <h1 style="font-size: 28px;">
        REPORTE DE EMPRESA
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row"><div class="col-md-6">
            <div class="nombre_empresa">
                <b><h3 style="font-weight: 700;"><?= $empresa->empresa ?></h3></b>
                <b><h4>REGISTRO DE TRANSACCIONES Y PRÉSTAMOS</h4></b>
            </div>
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
        <div class="col-md-12">
            <div id="accordion-reportes-empresas">
               <?php if($reporteEmpresas == ''){
                   echo '<p>No se encontraron registros!</p>';
               } ?>
            </div>
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-info" data-toggle="modal" data-target="#nueva-transaccion-y-compromisol"> <span class="glyphicon glyphicon-plus-sign"></span> Nuevo Registro</button>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <b><h4>REPORTE FINANCIERO</h4></b><br>
            <div class="panel panel-default">
                <div class="panel-body">

            <div class="row ">
                <div class="col-md-12">
                    <div id="div-tabla-cajas"><?= $cajas ?></div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modal-nueva-caja"><span class="glyphicon glyphicon-plus-sign"></span>Nuevo</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="div-tabla-favores"><?= $favores ?></div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modal-nueva-favor"><span class="glyphicon glyphicon-plus-sign"></span>Nuevo</button>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="div-tabla-contras"><?= $contras ?></div>
                </div>
                <div class="col-md-12 text-right">
                    <button class="btn btn-info" data-toggle="modal" data-target="#modal-nueva-contra"><span class="glyphicon glyphicon-plus-sign"></span>Nuevo</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="div-balance-general">
                        <?= $balance ?>
                    </div>
                </div>
            </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <b><h4>COMENTARIOS</h4></b><br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <textarea class="form-control" id="comentario" style="min-height: 350px;"><?= $empresa->comentario_reporte_empresa ?></textarea><br>
                    <div class="text-right">
                        <button id="btn-comentario" class="btn btn-info">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>