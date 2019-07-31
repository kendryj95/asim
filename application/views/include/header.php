<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Plataforma | CEI</title>
        <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url('assets/css/skin-red.css') ?>">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/css/blue.css') ?>">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/jquery-jvectormap-1.2.2.css') ?>">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?= base_url('assets/css/datepicker3.css') ?>">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/css/daterangepicker-bs3.css') ?>">
    <!-- Bootstrap Datatables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <!-- Jquery UI Datatables -->
    <!-- <link rel="stylesheet" href="<?//= base_url('assets/css/jquery.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?//= base_url('assets/css/buttons.bootstrap.min.css') ?>"> -->
    <!-- My customs CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <!-- Sweet Alerts -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert.css') ?>">
    <!-- Morris -->
    <link rel="stylesheet" href="<?= base_url('assets/css/morris.css') ?>">
    <!-- Bootstrap Toggle -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>">

</head>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= base_url() ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>CEI</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Plataforma</b> CEI</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user shadowsbox">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> <?= $session['nombre'] ?></a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?= base_url('login/logout') ?>"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesión</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">PRINCIPAL</li>
                <li class="treeview">
                    <a href="<?= base_url('dashboard') ?>">
                        <i class="fa fa-home"></i> <span>Dashboard</span>  <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="<?= base_url('resumenSaldo') ?>">
                        <i class="fa fa-table"></i> <span>Resumen Saldo</span>  <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="<?= base_url('reportePropiedades') ?>">
                        <i class="fa fa-book"></i> <span>Reporte de Propiedades</span>  <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li id="seccion-red" class="header">RED</li>
                <?= $red ?>
                <?php if($session['tipo'] == 1): ?>
                <li class="header">CONFIGURACIÓN</li>
                 <li class="treeview">
                    <a href="<?= base_url('empresas') ?>">
                        <i class="fa fa-building"></i> <span>Empresas</span>  <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <li class="treeview">
                    <a href="<?= base_url('usuarios') ?>">
                        <i class="fa fa-users"></i> <span>Usuarios</span>  <i class="fa fa-angle-left pull-right"></i>
                    </a>
                </li>
                <?php endif ?>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">