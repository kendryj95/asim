<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?= $nVerdes ?> <?php $tr = ($nVerdes ==1 ) ? 'Transacción':'Transacciones'; echo $tr ?></h3>

                    <p>Mas de 45 días de su vencimiento</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?= $nAmarillos ?> <?php $tr = ($nAmarillos==1) ? 'Transacción':'Transacciones'; echo $tr ?></h3>

                    <p>Entre 45 y 20 días de su vencimiento</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>

            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><?= $nRojos ?> Transacciones</h3>

                    <p>Menos de 20 días de su vencimiento</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>

            </div>
        </div>

    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <h2>Menos de 20 días de su vencimiento</h2>
            <?= $rojos ?>
        </div>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <h2>Entre 45 y 20 días de su vencimiento</h2>
            <?= $amarillos ?>
        </div>
    </div>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <h2>Mas de 45 días de su vencimiento</h2>
            <?= $verdes ?>
        </div>
    </div>

</section>
<!-- /.content -->