<?php
require_once('../modelo/clsDashboard.php');

require_once('../modelo/clsPerfil.php');

$objPer = new clsPerfil();
$opciones = $objPer->listarOpciones($_SESSION['idperfil']);
$fila = $opciones->fetchAll(PDO::FETCH_NAMED);

$objDashboard = new clsDashboard();

$lisTarg = $objDashboard->listarTargetas();
$lisTarg = $lisTarg->fetch(PDO::FETCH_NAMED);


/* $reservas = $objDashboard->consultarReservas();
$reservas = $reservas->fetchAll(PDO::FETCH_NAMED);

$calendar = $objDashboard->consultarCalendar();
$calendar = $calendar->fetchAll(PDO::FETCH_NAMED); */

/*     var_dump($reservas);
    die(); */

?>

<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning">
      <div class="card-header">
        <h3 class="card-title">Resumen</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3 col-6">

            <div class="small-box bg-info pb-2">
              <div class="inner">
                <h3><?= $lisTarg['totaltipohabitacion']; ?></h3>
                <p>Tipos de Habitacion</p>
              </div>
              <div class="icon">
                <i class="fas fa-tags"></i>
              </div>
              <a href="javascript:void(0)" onclick="AbrirPagina('<?= $fila[2]['url']; ?>')" class="nav-link small-box-footer ">
                Administrar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-6">

            <div class="small-box bg-success pb-2">
              <div class="inner">
                <h3><?= $lisTarg['totalhabitacion']; ?></h3>
                <p>Habitaciones</p>
              </div>
              <div class="icon">
                <i class="fas fa-hotel"></i>
              </div>
              <a href="javascript:void(0)" onclick="AbrirPagina('<?= $fila[3]['url']; ?>')" class="nav-link small-box-footer">
                Administrar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-6">

            <div class="small-box bg-maroon pb-2">
              <div class="inner">
                <h3><?= $lisTarg['totalhuesped']; ?></h3>
                <p>Huespedes</p>
              </div>
              <div class="icon">
                <i class="fas fa-id-card"></i>
              </div>
              <a href="javascript:void(0)" onclick="AbrirPagina('<?= $fila[4]['url']; ?>')" class="nav-link small-box-footer">
                Administrar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-6">

            <div class="small-box bg-danger pb-2">
              <div class="inner">
                <h3><?= $lisTarg['totalhospedaje']; ?></h3>
                <p>Hospedajes</p>
              </div>
              <div class="icon">
                <i class="fas fa-luggage-cart"></i>
              </div>
              <a href="javascript:void(0)" onclick="AbrirPagina('<?= $fila[5]['url']; ?>')" class="nav-link small-box-footer">
                Administrar <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-list"></i>&nbsp;
                  Reservas de huéspedes
                </h3>
              </div>

              <div class="card-body">
                <?php foreach ($reservas as $event => $value): ?>
                  <div class="alert bg-lightblue">
                    <h5><i class="icon fas fa-user"></i><?php echo $value['title']; ?> &nbsp; <small class="badge badge-danger"><i class="fas fa-calendar-alt"></i>&nbsp; <?php echo $value['fechareserva']; ?></small></h5>
                    <?php echo $value['observacion']; ?>
                  </div>
                <?php endforeach; ?>
              </div>

            </div>
          </div>

          <div class="col-md-7">
            <div class="card">
              <div id="calendar">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  function verCalendar() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: "es",
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: <?php echo json_encode($calendar); ?>
    });
    calendar.render();
  }

  verCalendar();
</script>