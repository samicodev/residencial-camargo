<?php
/* require_once('../modelo/clsHuesped.php');

  $objHues = new clsHuesped();

  $listaTipoDocumento = $objHues->consultarTipoDocumento();
  $listaTipoDocumento = $listaTipoDocumento->fetchAll(PDO::FETCH_NAMED);
 */
require_once('../modelo/clsHospedaje.php');


 $objHos = new clsHospedaje();
  
    $listaMetodoPago = $objHos->consultarTipoMetodoPago();
    $listaMetodoPago = $listaMetodoPago->fetchAll(PDO::FETCH_NAMED);
?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning shadow-none">
      <div class="card-header">
        <h3 class="card-title">Listado de Cajas</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Apertura</span>
              </div>
              <input type="date" class="form-control " name="BusqFechApert" id="BusqFechApert" onchange="verListado()">
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Cierre</span>
              </div>
              <input type="date" class="form-control " name="BusqFechCie" id="BusqFechCie" onchange="verListado()">
            </div>
          </div>
          <!-- <div class="col-md-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">Estado</span>
                </div>
                <select class="form-control" name="cboBusquedadEstado" id="cboBusquedadEstado" onchange="verListado()">
                  <option value="">- Todos -</option>
                  <option value="1">Activos</option>
                  <option value="0">Anulados</option>
                </select>
              </div>
            </div> -->
          <div class="col-md-4">
            <!-- <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button> -->
            <button type="button" class="btn btn-success" onclick="abrirModalCaja()"><i class="fas fa-plus-circle"></i> Nuevo</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoCaja">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modalCaja" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Apertura de caja</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formCaja" id="formCaja">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="saldoinicial">Saldo Inicial</label>
                <input type="number" class="form-control" id="saldoinicial" name="saldoinicial" placeholder="0.00" step="0.01" min="0">
                <input type="hidden" name="idcaja" id="idcaja" value="">
              </div>
              <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea class="form-control" rows="3" placeholder="Observaciones..." id="observacion" name="observacion" style="resize: none;"></textarea>
              </div>
              <div class="form-group" style="display: none;">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                  <option value="1">ACTIVO</option>
                  <option value="0">ANULADO</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-around">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarCaja()"><i class="fa fa-save"></i> Registrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalEgreso" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Registro de egreso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="formEgreso" id="formEgreso">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="idcaja_egreso" id="idcaja_egreso">
              <div class="form-group">
                <label for="metodo_pago">Metodo de Pago</label>
                <select name="metodo_pago" id="metodo_pago" class="form-control">
                  <option value="">- Seleccione -</option>
                  <?php foreach ($listaMetodoPago as $k => $v) { ?>
                    <option value="<?= $v['idmetodopago'] ?>"><?= $v['nombre'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="monto_pago">Monto de pago</label>
                <input type="number" class="form-control" id="monto_pago" name="monto_pago" step="0.1" min="0" placeholder="0.00">
              </div>
              <div class="form-group">
                <label for="detalle">Detalle</label>
                <textarea class="form-control" rows="3" placeholder="Detalle..." id="detalle" name="detalle" style="resize: none;"></textarea>
              </div>
              <div class="form-group" style="display: none;">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                  <option value="1">ACTIVO</option>
                  <option value="0">ANULADO</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer justify-content-around">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardarEgreso()"><i class="fa fa-save"></i> Registrar</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalTransacciones" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Transacciones de la caja</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="fpdf/reporteTransacciones.php" method="POST" target="_blank">
        <input type="hidden" name="idcajatransaccion" id="idcajatransaccion">
        <div class="row">
        <div class="col-md-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha inicial</span>
              </div>
              <input type="date" class="form-control " name="BusqFechIni" id="BusqFechIni">
            </div>
          </div>
          <div class="col-md-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha final</span>
              </div>
              <input type="date" class="form-control " name="BusqFechFin" id="BusqFechFin">
            </div>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" onclick="verTransacciones()"><i class="fa fa-search"></i></button>
            <button type="submit" class="btn btn-danger"><i class="fa fa-file-pdf"></i></button>
          </div>
        </div>
        </form>
        <hr>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="ListadoTransacciones">
              <thead class="bg-info">
                <tr>
                  <th>Fecha y Hora</th>
                  <th>Responsable</th>
                  <th>Detalle</th>
                  <th>Monto</th>
                  <th>Metodo de pago</th>
                  <th>Tipo de movimiento</th>
                  <th>Persona</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<script>
  function verListado() {
    $("#divListadoHuesped").html('<div class="loader"><div class="justify-content-center jimu-primary-loading"></div></div>');
    $.ajax({
        method: "POST",
        url: "vista/cajas_listado.php",
        data: {
          fechaapertura: $('#BusqFechApert').val(),
          fechacierre: $('#BusqFechCie').val()
          /* estado: $('#cboBusquedadEstado').val() */
        }
      })
      .done(function(resultado) {
        $('#divListadoCaja').html(resultado);
      })
  }

  verListado();

  function guardarCaja() {
    if (validarFormulario()) {
      var datos = $('#formCaja').serializeArray();
      var idcaja = $('#idcaja').val();
      if (idcaja != "") {
        datos.push({
          name: "accion",
          value: "ACTUALIZAR"
        });
      } else {
        datos.push({
          name: "accion",
          value: "NUEVO"
        });
      }

      $.ajax({
          method: "POST",
          url: "controlador/contCaja.php",
          data: datos,
          dataType: 'json'
        })
        .done(function(resultado) {
          if (resultado.correcto == 1) {
            toastCorrecto(resultado.mensaje);
            $('#modalCaja').modal('hide');
            $('#formCaja').trigger('reset');
            verListado()
          } else {
            toastError(resultado.mensaje)
            $('#modalCaja').modal('hide');
          }
        });
    }
  }

  function validarFormulario() {
    let correcto = true;
    let saldoinicial = $('#saldoinicial').val();
    const regex = /^\d+(\.\d{1,2})?$/;

    $('.obligatorio').removeClass('is-invalid');

    if (!regex.test(saldoinicial)) {
      toastError('Se debe agregar un monto con dos decimales');
      $('#saldoinicial').addClass('is-invalid');
      correcto = false;
    }

    return correcto;
  }

  function abrirModalCaja() {
    $('#formCaja').trigger('reset');
    $('#idcaja').val("");

    $('#saldoinicial').prop('disabled', false);
    $('#modalCaja').modal('show');

    $('#saldoinicial').removeClass('is-invalid');
    $('#observacion').removeClass('is-invalid');
  }


  function abrirModalEgreso(idcaja) {
    $('#formEgreso').trigger('reset');
    $('#idcaja_egreso').val(idcaja);
    $('#modalEgreso').modal('show');

    $('#metodo_pago').removeClass('is-invalid');
    $('#monto_pago').removeClass('is-invalid');
    $('#detalle').removeClass('is-invalid');
  }

  function guardarEgreso(){
  if(validarFormularioEgreso()){
    var datos = $('#formEgreso').serializeArray();
    datos.push({name: "accion", value: "NUEVO_EGRESO"});

    $.ajax({
      method: "POST",
      url: "controlador/contCaja.php",
      data: datos,
      dataType: 'json'
    })
    .done(function(resultado){
      if(resultado.correcto==1){
        toastCorrecto(resultado.mensaje);
        $('#modalEgreso').modal('hide');
        $('#formEgreso').trigger('reset');

        verListado()
      }else{
        toastError(resultado.mensaje)
      }
    });
  }
}

function validarFormularioEgreso(){
  let correcto = true;
  let metodo_pago = $('#metodo_pago').val();
  let monto_pago = $('#monto_pago').val();
  let detalle = $('#detalle').val();

  $('.obligatorio').removeClass('is-invalid');

  if(metodo_pago==""){
      toastError('Seleccione un metodo de pago');
      $('#metodo_pago').addClass('is-invalid');
      correcto = false;
    }
    if(monto_pago==""){
      toastError('Ingrese el monto de pago');
      $('#monto_pago').addClass('is-invalid');
      correcto = false;
    }
    if(detalle==""){
      toastError('Ingrese el detalle de la transacción');
      $('#detalle').addClass('is-invalid');
      correcto = false;
    }
    
  return correcto;
}

  function verTransacciones(){
    if(validarRangoFecha()){
      let idcajatransaccion = $('#idcajatransaccion').val();
      let fechainicio = $('#BusqFechIni').val();
      let fechafin = $('#BusqFechFin').val();

    $.ajax({
    		method: "POST",
    		url: "controlador/contCaja.php",
    		data: {
    			accion: 'VER_TRANSACCIONES',
    			idcaja: idcajatransaccion,
          fechainicio:fechainicio,
          fechafin:fechafin
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
				$('#ListadoTransacciones tbody').empty();

				if (resultado.length === 0) {
					$('#ListadoTransacciones tbody').append(
							'<tr><td colspan="6" class="text-center">No se tiene registros</td></tr>'
					);
				} else {

            let totalIngresos = 0;
            let totalEgresos = 0;


						for (var i = 0; i < resultado.length; i++) {

							var colorFondo = resultado[i].tipotransaccion === 'Ingreso' ? 'background-color: #9acc77;' : 'background-color: #f7a398;';

              if (resultado[i].tipotransaccion === 'Ingreso') {
                    totalIngresos += parseFloat(resultado[i].monto);
                } else if (resultado[i].tipotransaccion === 'Egreso') {
                    totalEgresos += parseFloat(resultado[i].monto); 
                }

								$('#ListadoTransacciones tbody').append(
										'<tr style="' + colorFondo + '">' +
												'<td>' + resultado[i].fechapago + '</td>' +
												'<td>' + resultado[i].responsable + '</td>' +
												'<td>' + resultado[i].descripcion + '</td>' +
												'<td>' + resultado[i].monto + '</td>' +
												'<td>' + resultado[i].metodopago + '</td>' +
												'<td>' + resultado[i].tipotransaccion + '</td>' +
												'<td>' + (resultado[i].nombcomp || 'Desconocido') + '</td>' +
										'</tr>'
								);

						}

          let saldoFinal = totalIngresos - totalEgresos;

          $('#ListadoTransacciones tbody').append(
              '<tr>' +
                  '<td colspan="5" class="text-right font-weight-bold">Total Ingresos:</td>' +
                  '<td colspan="2">' + totalIngresos.toFixed(2) + '</td>' +
              '</tr>'
          );
          $('#ListadoTransacciones tbody').append(
              '<tr>' +
                  '<td colspan="5" class="text-right font-weight-bold">Total Egresos:</td>' +
                  '<td colspan="2">' + totalEgresos.toFixed(2) + '</td>' +
              '</tr>'
          );
          $('#ListadoTransacciones tbody').append(
              '<tr>' +
                  '<td colspan="5" class="text-right font-weight-bold">Saldo Final (Ingresos - Egresos):</td>' +
                  '<td colspan="2">' + saldoFinal.toFixed(2) + '</td>' +
              '</tr>'
          );
				}
    	});
    }
  }

  function validarRangoFecha(){
  let correcto = true;
  let fechainicio = $('#BusqFechIni').val();
  let fechafin = $('#BusqFechFin').val();

  $('.obligatorio').removeClass('is-invalid');

  if(fechainicio==""){
    toastError('Seleccione una fecha de inicio para la busqueda');
    $('#BusqFechIni').addClass('is-invalid');
    correcto = false;
  }else{
    $('#BusqFechIni').removeClass('is-invalid');
  }

  if(fechafin==""){
    toastError('Seleccione una fecha final para la busqueda');
    $('#BusqFechFin').addClass('is-invalid');
    correcto = false;
  }else{
    $('#BusqFechFin').removeClass('is-invalid');
  }
    
  return correcto;
}




</script>