<?php

  require_once('../modelo/clsHuesped.php');

  $objHues = new clsHuesped();

    $listaTipoDocumento = $objHues->consultarTipoDocumento();
    $listaTipoDocumento = $listaTipoDocumento->fetchAll(PDO::FETCH_NAMED);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning shadow-none">
      <div class="card-header">
        <h3 class="card-title">Listado de Hospedajes</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
        <form action="fpdf/reporteGeneral.php" method="POST" target="_blank">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Mostrar desde</span>
              </div>
              <input type="text" class="form-control float-right" name="BusqFechaRango" id="BusqFechaRango" onchange="verListado()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Ingreso</span>
              </div>
              <input type="date" class="form-control " name="BusqFechaIncio" id="BusqFechaIncio" onchange="verListado()" >
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Salida</span>
              </div>
              <input type="date" class="form-control " name="BusqFechaSalida" id="BusqFechaSalida" onchange="verListado()" >
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nro Habitacion</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaHabitacion" id="txtBusquedaHabitacion" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nro Documento</span>
              </div>
              <input type="nunber" class="form-control" name="txtBusquedaNroDoc" id="txtBusquedaNroDoc" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-6">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
            <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i> Generar PDF</button>
          </form>
            <a href="fpdf/reporteDiario.php" class="btn bg-maroon" target="_blank"><i class="fa fa-file-pdf"></i>&nbsp; Reporte diario</a>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoReporte">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $('#BusqFechaRango').daterangepicker({
    locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie','Sab'],
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

  
function verListado(){
  $("#divListadoReporte").html('<div class="loader"><div class="justify-content-center jimu-primary-loading"></div></div>');
    $.ajax({
      method: "POST",
      url: "vista/reportes_listado.php",
      data:{
        habitacion: $('#txtBusquedaHabitacion').val(),
        nrodoc: $('#txtBusquedaNroDoc').val(),
        fechaingreso: $('#BusqFechaIncio').val(),
        fechasalida: $('#BusqFechaSalida').val(),
        fecharango: $('#BusqFechaRango').val()
      }
    })
    .done(function(resultado){
      $('#divListadoReporte').html(resultado);
    })
}


verListado();


</script>