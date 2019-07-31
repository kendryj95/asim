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
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/css/AdminLTE.min.css') ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= base_url('assets/css/skin-red.css') ?>">
     <!-- My customs CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">

</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Plataforma </b>CEI
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Iniciar Sesión</p>
      <div class="login-alert displayNone">
        <span class="glyphicon glyphicon-ban-circle"></span>
        <span>Usuario invalido</span>
      </div>
    <form id="form-login">
      <div class="form-group has-feedback">
        <input name="user" type="text" class="form-control" placeholder="Usuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
          <input name="pass" type="password" class="form-control" placeholder="Contraseña" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
          <button type="submit" class="btn btn-danger btn-block loginbtn">Iniciar</button>
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/js/app.min.js') ?>"></script>
<!-- Jquery Validate -->
<script src="<?= base_url('assets/js/jquery.validate.js') ?>"></script>
<!-- Auth User -->
<script src="<?= base_url('assets/js/auth-user.js') ?>"></script>
</body>
</html>