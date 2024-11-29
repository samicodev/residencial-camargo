<?php

require_once('modelo/clsPerfil.php');
require_once('modelo/clsResumen.php');

$objPer = new clsPerfil();
$opciones = $objPer->listarOpciones($_SESSION['idperfil']);

$objResumen = new clsResumen();

$habitacionesOcupadas = $objResumen->contarhabitacionesOcupadas();
$habitacionesOcupadas = $habitacionesOcupadas->fetch(PDO::FETCH_ASSOC);

$habitacionesDisponibles = $objResumen->contarhabitacionesDisponibles();
$habitacionesDisponibles = $habitacionesDisponibles->fetch(PDO::FETCH_ASSOC);

$habitacionesLimpieza = $objResumen->contarhabitacionesLimpieza();
$habitacionesLimpieza = $habitacionesLimpieza->fetch(PDO::FETCH_ASSOC);

$huespedeEncurso = $objResumen->contarhuespedesEncurso();
$huespedeEncurso = $huespedeEncurso->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HOTEL RESIDENCIAL CAMARGO</title>
  <link rel="shortcut icon" href="dist/img/logo.png" type="image/x-icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- fileinput -->
  <link rel="stylesheet" href="plugins/fileinput/css/fileinput.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- fileinput -->
  <link rel="stylesheet" href="plugins/fileinput/css/fileinput.css">

  <!-- Fullcalendar -->
  <script src="plugins/fullcalendar/main.js"></script>
  <script src="plugins/fullcalendar/locales/es.js"></script>
  <link rel="stylesheet" href="plugins/fullcalendar/main.css">

  <!-- Loader -->
  <style>
    .loader {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
    }

    .jimu-primary-loading:before,
    .jimu-primary-loading:after {
      position: absolute;
      top: 0;
      content: '';
    }

    .jimu-primary-loading:before {
      left: -19.992px;
    }

    .jimu-primary-loading:after {
      left: 19.992px;
      -webkit-animation-delay: 0.32s !important;
      animation-delay: 0.32s !important;
    }

    .jimu-primary-loading:before,
    .jimu-primary-loading:after,
    .jimu-primary-loading {
      background: #076fe5;
      -webkit-animation: loading-keys-app-loading 0.8s infinite ease-in-out;
      animation: loading-keys-app-loading 0.8s infinite ease-in-out;
      width: 13.6px;
      height: 32px;
    }

    .jimu-primary-loading {
      text-indent: -9999em;
      margin: auto;
      position: absolute;
      right: calc(50% - 6.8px);
      top: calc(50% - 16px);
      -webkit-animation-delay: 0.16s !important;
      animation-delay: 0.16s !important;
    }

    @-webkit-keyframes loading-keys-app-loading {

      0%,
      80%,
      100% {
        opacity: .75;
        box-shadow: 0 0 #076fe5;
        height: 32px;
      }

      40% {
        opacity: 1;
        box-shadow: 0 -8px #076fe5;
        height: 40px;
      }
    }

    @keyframes loading-keys-app-loading {

      0%,
      80%,
      100% {
        opacity: .75;
        box-shadow: 0 0 #076fe5;
        height: 32px;
      }

      40% {
        opacity: 1;
        box-shadow: 0 -8px #076fe5;
        height: 40px;
      }
    }
  </style>

  <!-- Togle switch -->
  <style>
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 55px;
      height: 26px;
      cursor: pointer;
    }

    .toggle-switch input[type="checkbox"] {
      display: none;
    }

    .toggle-switch-background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: #ddd;
      border-radius: 20px;
      box-shadow: inset 0 0 0 2px #ccc;
      transition: background-color 0.3s ease-in-out;
    }

    .toggle-switch-handle {
      position: absolute;
      top: 3px;
      left: 5px;
      width: 20px;
      height: 20px;
      background-color: #fff;
      border-radius: 50%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease-in-out;
    }

    .toggle-switch::before {
      content: "";
      position: absolute;
      top: -25px;
      right: -35px;
      font-size: 12px;
      font-weight: bold;
      color: #aaa;
      text-shadow: 1px 1px #fff;
      transition: color 0.3s ease-in-out;
    }

    .toggle-switch input[type="checkbox"]:checked+.toggle-switch-handle {
      transform: translateX(45px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2), 0 0 0 3px #05c46b;
    }

    .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background {
      background-color: #05c46b;
      box-shadow: inset 0 0 0 2px #04b360;
    }

    .toggle-switch input[type="checkbox"]:checked+.toggle-switch:before {
      content: "On";
      color: #05c46b;
      right: -15px;
    }

    .toggle-switch input[type="checkbox"]:checked+.toggle-switch-background .toggle-switch-handle {
      transform: translateX(25px);
    }
  </style>


</head>

<body class=" sidebar-mini layout-fixed"><!-- sidebar-collapse -->
  <div class="wrapper">

    <!-- Preloader -->
    <!--   <div class="preloader flex-column justify-content-center align-items-center">
    <div class="spinner-border text-primary"  role="status">
    </div>
  </div>
 -->
    <div class="loader preloader">
      <div class="justify-content-center jimu-primary-loading"></div>
    </div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <div class="theme-switch-wrapper nav-link">
            <label class="toggle-switch theme-switch">
              <input type="checkbox">
              <div class="toggle-switch-background">
                <div class="toggle-switch-handle"></div>
              </div>
            </label>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">

        <img src="dist/img/logo.png" alt="Siscamargo Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">RES. CAMARGO</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 d-flex">
          <div class="image">
            <img src="<?= $_SESSION['urlimagen'] ?>" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info" style="margin-top: -10px;">
            <a href="#" class="d-block text-light"><?= strtoupper($_SESSION['usuario']); ?></a>
            <a href="#" class="d-block text-warning"><?= $_SESSION['rol']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="principal.php" class="nav-link active"><i class="nav-icon fas fa-th"></i>
                <p>Panel resumen</p>
              </a>
            </li>

            <?php while ($fila = $opciones->fetch(PDO::FETCH_NAMED)) { ?>
              <li class="nav-item">
                <a href="javascript:void(0)" onclick="AbrirPagina('<?= $fila['url'] ?>')" class="nav-link">
                  <i class="nav-icon fas <?= $fila['icono'] ?>"></i>
                  <p><?= $fila['descripcion'] ?></p>
                </a>
              </li>
            <?php } ?>

            <li class="nav-item">
              <a href="index.php" class="nav-link bg-danger"><i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Cerrar sesión</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="divPrincipal">

      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-8">
              <h1 class="m-0">Panel resumen</h1>
            </div>
            <div class="col-sm-4">
              <h1 class="m-0"></h1>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box shadow">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bed"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Habitaciones Ocupados</span>
                  <span class="info-box-number">
                    <?= $habitacionesOcupadas['habitacionocupada']; ?>
                  </span>
                </div>

              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3 shadow">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hotel"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Habitaciones Disponibles</span>
                  <span class="info-box-number"><?= $habitacionesDisponibles['habitaciondisponible']; ?></span>
                </div>

              </div>

            </div>


            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3 shadow">
                <span class="info-box-icon bg-maroon elevation-1"><i class="fas fa-hand-sparkles"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Habitaciones en Limpieza</span>
                  <span class="info-box-number"><?= $habitacionesLimpieza['habitacionlimpiando']; ?></span>
                </div>

              </div>

            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3 shadow">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-clock"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Huéspedes en Curso</span>
                  <span class="info-box-number"><?= $huespedeEncurso['huespedescurso']; ?></span>
                </div>

              </div>

            </div>

          </div>

        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card shadow">
            <div class="card-header ">
              <h3 class="card-title">Consultar datos por intervalo de fecha</h3>
              <div class="card-tools">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">Mostrar desde</span>
                  </div>
                  <input type="text" class="form-control float-right" name="BusqDatosRango" id="BusqDatosRango" onchange="actualizarDatos()">
                </div>
              </div>

            </div>

            <div class="card-body">
              <!-- <div class="row">
                <div class="col-lg-3 col-6">

                  <div class="small-box bg-info shadow">
                    <div class="inner">
                      <h3 id="nuevosHuespedes"></h3>
                      <p>Huéspedes Nuevos</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-id-card"></i>
                    </div>
                    
                  </div>
                </div>
                <div class="col-lg-3 col-6">

                  <div class="small-box bg-success shadow">
                    <div class="inner">
                      <h3 id="hospedajesRealizados"></h3>
                      <p>Hospedajes Realizados</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-luggage-cart"></i>
                    </div>
                    
                  </div>
                </div>
                <div class="col-lg-3 col-6">

                  <div class="small-box bg-warning shadow">
                    <div class="inner">
                      <h3 id="huespedesRegistrados"></h3>
                      <p>Huéspedes Alojados</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-house-user"></i>
                    </div>
                    
                  </div>
                </div>
                <div class="col-lg-3 col-6">

                  <div class="small-box bg-danger shadow">
                    <div class="inner">
                      <h3 id="huespedesFrecuentes"></h3>
                      <p>Huéspedes Frecuentes</p>
                    </div>
                    <div class="icon">
                      <i class="fas fa-users"></i>
                    </div>
                    
                  </div>
                </div>
              </div> -->

              <div class="row">
                <div class="col-md-6">
                  <div class="card shadow" >
                    <div class="card-header bg-primary">
                      <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Gráfico por mes</h3>
                    </div>
                    <div class="card-body" >
                      <div class="chart">
                        <div class="chartjs-size-monitor">
                          <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                          </div>
                          <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                          </div>
                        </div>
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 337px;" class="chartjs-render-monitor"></canvas>
                      </div>
                    </div>

                  </div>

                </div>
                <div class="col-md-6">
                  <div class="card shadow">
                    <div class="card-header bg-danger">
                      <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Gráfico por total</h3>
                    </div>
                    <div class="card-body">
                      <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                          <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                          <div class=""></div>
                        </div>
                      </div>
                      <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 330px;" width="660" height="500" class="chartjs-render-monitor"></canvas>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer text-sm">
      <strong>Copyright &copy; 2024 <a href="#">Samuel Mamani</a>.</strong>
      Totos los derechos reservados.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.1.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- /.modal de confirmacion-->
  <div class="modal fade" id="modalConfirmacion">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h4 class="modal-title">Confirmar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="mensaje_confirmacion">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          <div id="boton_confirmacion">

          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <!--
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
          -->
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- fileinput -->
  <script src="plugins/fileinput/js/fileinput.js"></script>
  <script src="plugins/fileinput/js/fileinput_locale_es.js"></script>


  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- File Input-->
  <script src="plugins/fileinput/js/fileinput.js"></script>
  <script src="plugins/fileinput/js/fileinput_locale_es.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!--
<script src="dist/js/pages/dashboard.js"></script>
          -->

  <script>
    let barChart;
    let pieChart;

    function actualizarDatos() {
      /* NUEVOS HUESPEDES */
      /* $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
          dataType: "json",
          data: {
            accion: 'HUESPEDES_NUEVOS',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {

          var nuevosHuespedes = resultado[0].nuevoshuespedes;

          $('#nuevosHuespedes').text(nuevosHuespedes);
        }); */

      /* HOSPEDAJES REALIZADOS */
      /* $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
          dataType: "json",
          data: {
            accion: 'HOSPEDAJES_REALIZADOS',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {

          var hospedajesRealizados = resultado[0].hospedajesrealizados;

          $('#hospedajesRealizados').text(hospedajesRealizados);
        }); */

      /* PROMEDIO DE ESTADIA */
      /* $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
    		  dataType: "json",
          data: {
            accion: 'PROMEDIO_ESTADIA',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {
          console.log(resultado);

          var promedioEstadia = resultado[0].promedioestadia;

          $('#promedioEstadia').text(promedioEstadia);
        }); */

      /* HUESPEDES FRECUENTES */
      /* $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
          dataType: "json",
          data: {
            accion: 'HUESPEDES_REGISTRADOS',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {

          var huespedesRegistrados = resultado[0].huespedesregistrados;

          $('#huespedesRegistrados').text(huespedesRegistrados);
        }); */


      /* HUESPEDES FRECUENTES */
      /* $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
          dataType: "json",
          data: {
            accion: 'HUESPEDES_FRECUENTES',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {

          var huespedesFrecuentes = resultado[0].huespedesfrecuentes;

          $('#huespedesFrecuentes').text(huespedesFrecuentes);
        }); */


      $.ajax({
          method: "POST",
          url: "controlador/contResumen.php",
          data: {
            accion: 'LISTAR_FLUJO_CAJA',
            BusqDatosRango: $('#BusqDatosRango').val()
          }
        })
        .done(function(resultado) {
          var data = JSON.parse(resultado);

          var mes = [];
          var ingresos = [];
          var egresos = [];

          // Variables para los totales
          var totalIngresos = 0;
          var totalEgresos = 0;

          // Recorrer los datos recibidos
          for (var i = 0; i < data.length; i++) {
            mes.push(data[i].mes);
            ingresos.push(data[i].total_ingresos);
            egresos.push(data[i].total_egresos);

            // Sumar ingresos y egresos totales
            totalIngresos += parseFloat(data[i].total_ingresos);
            totalEgresos += parseFloat(data[i].total_egresos);
          }

          
          var totalGeneral = totalIngresos + totalEgresos;

          var porcentajeTotalIngresos = (totalIngresos / totalGeneral) * 100;
          var porcentajeTotalEgresos = (totalEgresos / totalGeneral) * 100;

          var labels = [
              `Ingresos (${porcentajeTotalIngresos.toFixed(2)}%)`,
              `Egresos (${porcentajeTotalEgresos.toFixed(2)}%)`
          ];

          // Definir los datos para el gráfico de barras
          var areaChartData = {
            labels: mes,
            datasets: [{
                label: 'Ingresos',
                backgroundColor: 'rgba(102,187,106,0.9)',
                borderColor: 'rgba(102,187,106,0.8)',
                data: ingresos
              },
              {
                label: 'Egresos',
                backgroundColor: 'rgba(239,83,80, 1)',
                borderColor: 'rgba(239,83,80, 1)',
                data: egresos
              }
            ]
          };

          var barChartCanvas = $('#barChart').get(0).getContext('2d');

          // Verifica si barChart ya existe
          if (barChart) {
            // Actualiza los datos y redibuja el gráfico existente
            barChart.data.labels = mes;
            barChart.data.datasets[0].data = ingresos;
            barChart.data.datasets[1].data = egresos;
            barChart.update(); // Redibuja el gráfico
          } else {
            // Crear una nueva instancia del gráfico si no existe
            var barChartOptions = {
              responsive: true,
              maintainAspectRatio: false,
              datasetFill: false
            };

            barChart = new Chart(barChartCanvas, {
              type: 'bar',
              data: areaChartData,
              options: barChartOptions
            });
          }

          // Crear los datos para el gráfico circular (pie chart)
          var pieData = {
            labels: labels,
            datasets: [{
              data: [totalIngresos, totalEgresos], // Totales de ingresos y egresos
              backgroundColor: ['#66bb6a', '#ef5350'] // Colores para ingresos y egresos
            }]
          };

          var pieChartCanvas = $('#pieChart').get(0).getContext('2d');

          // Verifica si pieChart ya existe
          if (pieChart) {
            // Actualiza los datos y redibuja el gráfico existente
            pieChart.data.datasets[0].data = [totalIngresos, totalEgresos];
            pieChart.update(); // Redibuja el gráfico
          } else {
            // Crear una nueva instancia del gráfico circular si no existe
            var pieOptions = {
              maintainAspectRatio: false,
              responsive: true
            };

            pieChart = new Chart(pieChartCanvas, {
              type: 'pie',
              data: pieData,
              options: pieOptions
            });
          }
        });
    }
  </script>


  <script>
    $('#BusqDatosRango').daterangepicker({
      locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      },
      startDate: moment().startOf('month'),
      endDate: moment().endOf('month'),
      ranges: {
        'Hoy': [moment(), moment()],
        'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
        'Este mes': [moment().startOf('month'), moment().endOf('month')],
        'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
    });
  </script>


  <script>
    function AbrirPagina(urlx) {
      $("#divPrincipal").html('<div class="loader"><div class="justify-content-center jimu-primary-loading"></div></div>');
      $.ajax({
        method: 'POST',
        url: urlx
      }).done(function(retorno) {
        $("#divPrincipal").html(retorno);
      });
    }

    function mostrarModalConfirmacion(mensaje, accion) {
      $("#mensaje_confirmacion").html(mensaje);

      btn_html = '<button type="button" class="btn btn-primary" onclick="CerrarModalConfirmacion();' + accion + '">Confirmar</button>';

      $("#boton_confirmacion").html(btn_html);
      $("#modalConfirmacion").modal("show");
    }

    function CerrarModalConfirmacion() {
      $("#modalConfirmacion").modal("hide");
    }

    function toastCorrecto(mensaje) {
      $(document).Toasts('create', {
        title: 'Correcto',
        class: 'bg-success',
        autohide: true,
        delay: 3000,
        body: mensaje
      });
    }

    function toastError(mensaje) {
      $(document).Toasts('create', {
        title: 'Error',
        class: 'bg-danger',
        autohide: true,
        delay: 3000,
        body: mensaje
      });
    }

    function cambiarPassword() {
      $.ajax({
        method: 'POST',
        url: 'vista/cambiarPassword.php'
      }).done(function(retorno) {
        $("#divPrincipal").html(retorno);
      });
    }
  </script>

  <script>
    var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    var currentTheme = localStorage.getItem('theme');
    var mainHeader = document.querySelector('.main-header');

    if (currentTheme) {
      if (currentTheme === 'dark') {
        if (!document.body.classList.contains('dark-mode')) {
          document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
          mainHeader.classList.add('navbar-dark');
          mainHeader.classList.remove('navbar-light');
        }
        toggleSwitch.checked = true;
      }
    }

    function switchTheme(e) {
      if (e.target.checked) {
        if (!document.body.classList.contains('dark-mode')) {
          document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
          mainHeader.classList.add('navbar-dark');
          mainHeader.classList.remove('navbar-light');
        }
        localStorage.setItem('theme', 'dark');
      } else {
        if (document.body.classList.contains('dark-mode')) {
          document.body.classList.remove("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-dark')) {
          mainHeader.classList.add('navbar-light');
          mainHeader.classList.remove('navbar-dark');
        }
        localStorage.setItem('theme', 'light');
      }
    }

    toggleSwitch.addEventListener('change', switchTheme, false);
  </script>

  <script>
    $('.main-sidebar').on('click', '.nav-link', function() {
      $('.nav-link').removeClass('active');
      $(this).addClass('active');
    });
  </script>





</body>

</html>