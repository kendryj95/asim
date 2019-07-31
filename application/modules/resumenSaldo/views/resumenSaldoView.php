<!-- Content Header (Page header) -->

<!-- Main content -->

<section class="content">

    <div class="row">

        <div class="col-md-12">

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

              <div class="panel panel-default">

                <div class="panel-heading" role="tab" id="headingOne" style="border-top: 4px solid #CE1126; display: flex; justify-content: space-between;">

                  <h4 class="panel-title">

                    <i class="fa fa-table"></i> Resumen Saldo

                  </h4>

                  <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color: rgba(0,0,0,.4);">

                    <i class="glyphicon glyphicon-minus"></i>

                  </a>

                </div>

                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

                    <div class="panel-body" style="padding: 15px;">

                        <div class="table-responsive">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 pull-left">
                                        <form action="<?= base_url() ?>resumenSaldo/perEmpresa" method="get">
                                            <span class="label label-default">Filtrar por:</span>
                                            <label for="">
                                                <select name="emp" id="filterEmp" class="form-control input-sm">
                                                    <option value="0">EMPRESA</option>
                                                    <?php foreach($empresas as $e): ?>
                                                        <option value="<?= $e->id ?>"><?= $e->empresa ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </label>
                                            <input type="submit" value="Filtrar" class="btn btn-default btn-sm" style="">
                                        </form>
                                </div>
                            </div> 

                            <?= $table ?>



                        </div>

                    </div>

                </div>

              </div>

            </div>

        </div>



    </div>

</section>

<!-- /.content -->





<div class="modal fade" id="view-resumen-saldo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h4 class="modal-title" id="myModalLabel"><span id="empDestino"></span> - <span id="empOrigen"></span></h4>

                </div>

                <div class="modal-body">

                    <table class="table table-striped">

                        <thead class="bg-info">

                            <th>Transaccion</th>

                            <th>Monto</th>

                            <th>Fecha de realización</th>

                        </thead>

                        <tbody class="bodyTable">

                            

                        </tbody>

                    </table>

                </div>



                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                </div>

        </div>

    </div>

</div>