<?php
  session_start();
  session_destroy();

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RESIDENCIAL CAMARGO</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Icon Hotel Camargo -->
  <link rel="shortcut icon" href="dist/img/logo.png" type="image/x-icon">


  <style>
     .fade-in {
        animation: fadeIn 0.5s forwards;
      }

      @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
      }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="login-logo">
    <img src="dist/img/camargo-logo.png" alt="Siscamargo Logo" width="200px">
  </div>
  <!-- /.login-logo -->
  <div class="card shadow-lg">
    <div class="card-body login-card-body">
      <h5 class="login-box-msg text-lightblue font-italic">SISTEMA WEB PARA LA GESTIÓN DE HUÉSPEDES</h5>
      <div class="alert alert-danger text-center d-none" role="alert" id="loginalert">Usuario o contraseña incorrectos. Por favor, inténtalo de nuevo.
      </div>
      <form action="principal.html" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Usuario" onkeyup="if(event.keyCode=='13'){ $('#pass').focus(); }" name="user" id="user" required autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-2">
          <input type="password" class="form-control" placeholder="Contraseña" onkeyup="if(event.keyCode=='13'){ ingresar(); }" name="pass" id="pass" required autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-1">
          <div class="offset-sm-12">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="mostrarPassword" onclick="cambiarTipoinput()">
              <label class="form-check-label" for="mostrarpassword">Mostrar contraseña</label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="button" onclick="ingresar()" class="btn btn-primary btn-block">Iniciar sesión</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script>
  
    function ingresar(){
      $.ajax({
        method: "POST",
        url: "controlador/contUsuario.php",
        data: {
          accion: 'INICIAR_SESION',
          usuario: $('#user').val(),
          password: $('#pass').val()
        },
        dataType: "json"
      })
      .done(function(resultado){
        if(resultado.correcto==0){
          $('#loginalert').removeClass('fade-in').removeClass('d-none');
          void $('#loginalert')[0].offsetWidth;
          $('#loginalert').addClass('fade-in');
          
        }else{
          window.open('principal.php','_self');
        }
      })
    }

    function cambiarTipoinput(){
      var inputPassword = $('#pass');
      if ($('#mostrarPassword').is(':checked')) {
          inputPassword.attr('type', 'text');
      } else {
          inputPassword.attr('type', 'password');
      }
    }

</script>
</body>
</html>