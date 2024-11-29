<?php
    require_once('../modelo/clsTipoHabitacion.php');
    require_once('../modelo/clsHuesped.php');
    require_once('../modelo/clsHospedaje.php');

    $objTipoHabitacion = new clsTipoHabitacion();

    $listaTipoHabitacion = $objTipoHabitacion->listarTipoHabitacion('','1');
    $listaTipoHabitacion = $listaTipoHabitacion->fetchAll(PDO::FETCH_NAMED);


    $objHues = new clsHuesped();
  
    $listaTipoDocumento = $objHues->consultarTipoDocumento();
    $listaTipoDocumento = $listaTipoDocumento->fetchAll(PDO::FETCH_NAMED);

    $objHos = new clsHospedaje();
  
    $listaMetodoPago = $objHos->consultarTipoMetodoPago();
    $listaMetodoPago = $listaMetodoPago->fetchAll(PDO::FETCH_NAMED);

?>
<section class="content-header">
  <div class="container-fluid">
    <div class="card card-warning shadow-none">
      <div class="card-header">
        <h3 class="card-title">Listado de Habitaciones</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
        </div>
      </div>
      <div class="card-body">
    
        <div class="row">
          <div class="col-md-2">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Habitacion</span>
              </div>
              <!-- Con el evento onkeyup puedes realizar la busquedad cada vez que escriba una letra onkeyup="verListado()" -->
              <input type="text" class="form-control" name="txtBusquedaHabitacion" id="txtBusquedaHabitacion" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Tipo de Habitacion</span>
              </div>
              <select class="form-control" name="cboBusquedadTipoHabitacion" id="cboBusquedadTipoHabitacion" onchange="verListado()">
                <option value="">- Todos -</option>
                <?php foreach($listaTipoHabitacion as $k=>$v){ ?>
                <option value="<?= $v['id_tipohabitacion'] ?>"><?= $v['nombre'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Estado de Habitacion</span>
              </div>
              <select class="form-control" name="cboBusquedadEstado" id="cboBusquedadEstado" onchange="verListado()">
                <option value="">- Todos -</option>
                <option value="0">Disponibles</option>
                <option value="1">Ocupados</option>
                <option value="2">En limpieza</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body pt-0">
      <div class="row mt-2 mb-2 ml-2">
        <span class="float-right badge bg-info mr-5">DISPONIBLE</span><span class="float-right badge bg-success mr-5">OCUPADO</span><span class="float-right badge bg-maroon mr-5">EN LIMPIEZA</span>
        </div>
        <div class="row">
          <div class="col-md-12" id="divListadoHabitacion">
                  
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modalHospedar" data-backdrop="static">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Hospedar</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHospedar" id="formHospedar">
                <input type="hidden" name="idhospedar" id="idhospedar" value="">
                <div class="row" id="bsqhuesped">
                  <div class="col-md-9">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Nro de Documento</span>
                      </div>
                      <input type="text" class="form-control" name="identificacion_hue" id="identificacion_hue" placeholder="Cedula/Pasaporte"  onkeyup="if(event.keyCode=='13'){ buscarHuesped(); }" >
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="button" class="btn btn-primary" onclick="buscarHuesped()"><i class="fas fa-search"></i></button>
                    <button type="button" class="btn btn-success" onclick="abrirModalHuesped()"><i class="fas fa-plus-circle"></i></button>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nom_huesped">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nom_huesped" name="nom_huesped" disabled>
                      <input type="hidden" name="idhuesped" id="idhuesped">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="resante">Procedencia</label>
                      <input type="text" class="form-control" id="resante" name="resante" placeholder="Residencia anterior">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="motviaje">Motivo de viaje</label>
                      <input type="text" class="form-control" id="motviaje" name="motviaje" placeholder="Motivo de viaje">
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarHospedar()" ><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="modalHuespedes_habitacion" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos del hospedaje</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="idhospedaje" id="idhospedaje">
              <input type="hidden" name="id_habitacionhos" id="id_habitacionhos">
              <input type="hidden" name="idhospedaje_saldopagar" id="idhospedaje_saldopagar">
                <div class="row mb-3">
                  <div class="col-md-7">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Fecha y hora de inicio</span>
                      </div>
                      <input type="text" class="form-control" name="fechainicio" id="fechainicio" disabled>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Número de habitación</span>
                      </div>
                      <input type="number" class="form-control" name="numerohabitacion" id="numerohabitacion" disabled>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-5">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Tipo de habitacion</span>
                      </div>
                      <input type="text" class="form-control" name="tipohabitacion" id="tipohabitacion" disabled>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Precio</span>
                      </div>
                      <input type="number" class="form-control" name="preciohabitacion" id="preciohabitacion" step="0.01" min="0" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Estadía (jornadas)</span>
                      </div>
                      <input type="number" class="form-control" name="duracionestadia" id="duracionestadia" min="1">
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-4">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-navy">Costo Total</span>
                      </div>
                      <input type="number" class="form-control bg-navy" name="costototal" id="costototal" step="0.01" min="0" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-warning">Total Pagado</span>
                      </div>
                      <input type="number" class="form-control bg-warning" name="totalpagado" id="totalpagado" step="0.01" min="0" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text bg-success">Por Pagar</span>
                      </div>
                      <input type="number" class="form-control bg-success" name="porpagar" id="porpagar" step="0.01" min="0" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-9">
                    <input type="hidden" id="cantidadHuespedes" name="cantidadHuespedes">
                      <div class="form-group">
                      <label for="observacion">Observación</label>
                      <textarea class="form-control" rows="3" placeholder="Observaciones..." id="observacion" name="observacion" style="resize: none;"></textarea>
                      </div>
                  </div>
                  <div class="col-md-3 d-flex flex-column justify-content-center">
                    <button type="button" class="btn btn-primary btn-block btn-sm" onclick="actualizarTiempoEstadia()"><i class="fas fa-edit"></i> Modificar</button>
                    <button type="button" class="btn btn-warning btn-block btn-sm" onclick="mostrarPagos()"><i class="fas fa-list-ol"></i> Pagos</button>
                    <button type="button" class="btn btn-danger btn-block btn-sm" onclick="finalizarEstadia()"><i class="fas fa-calendar-week"></i> Finalizar</button>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="ListadoHuespedes">
                        <thead class="bg-info">
                          <tr>
                            <th colspan="6" style="text-align: center;">LISTADO DE HUESPEDES</th>
                          </tr>
                          <tr>
                            <th>Nombre</th>
                            <th>Numero de documento</th>
                            <th>Nacionalidad</th>
                            <th>Edad</th>
                            <th>Procedencia</th>
                            <th>Opcion</th>
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

<div class="modal fade" id="modalPagosHospedaje" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
              <h4 class="modal-title">Pagos del hospedaje</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <input type="hidden" id="usis" name="usis" value="<?= $_SESSION['nombreusu']?>">
                <div class="row">
                  <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="ListadoPagos">
                        <thead class="bg-warning">
                          <tr>
                            <th colspan="6" style="text-align: center;">LISTADO DE PAGOS</th>
                          </tr>
                          <tr>
                            <th>Nombre</th>
                            <th>Monto</th>
                            <th>Metodo de pago</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Comprobante</th>
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

<div class="modal fade" id="modalHuesped" data-backdrop="static">
  <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-lightblue">
              <h4 class="modal-title">Datos del Huesped</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formHuesped" id="formHuesped">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nomhuesped">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nomhuesped" name="nomhuesped" placeholder="Nombre(s) y apellidos">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="profesion">Profesión</label>
                      <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Ocupación">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nrodoc">Número de Documento</label>
                      <input type="text" class="form-control" id="nrodoc" name="nrodoc" placeholder="Número de identidad">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipodoc">Tipo de Documento</label>
                        <select name="tipodoc" id="tipodoc" class="form-control">
                          <option value="">- Seleccione -</option>
                          <?php foreach($listaTipoDocumento as $k=>$v){ ?>
                            <option value="<?= $v['id_tipodocumento'] ?>"><?= $v['nombre'] ?></option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" placeholder="Procedencia">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="fenac">Fecha de Nacimiento</label>
                      <input type="date" class="form-control" id="fenac" name="fenac">
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarHuesped()" ><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

    <div class="modal fade" id="modalTransaccion" data-backdrop="static">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header bg-success">
              <h4 class="modal-title">Datos del Pago</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formTransaccion" id="formTransaccion">
                <input type="hidden" name="idhospedaje_pago" id="idhospedaje_pago">
                <input type="hidden" name="idhospedar_pago" id="idhospedar_pago">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nomhuesped_pago">Nombre y Apellidos</label>
                      <input type="text" class="form-control" id="nomhuesped_pago" name="nomhuesped_pago" placeholder="Nombre(s) y apellidos" disabled>
                      <input type="hidden" name="idhuesped_pago" id="idhuesped_pago">
                    </div>
                  </div>
                  <!-- <div class="col-md-6">
                    <div class="form-group">
                      <label for="costotoal">Costo total por hospedaje</label>
                      <input type="number" class="form-control" id="costotoal" name="costotoal" step="0.1" disabled>
                    </div>
                  </div> -->
                </div>
                <div class="row">
                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="saldopagar">Saldo por pagar</label>
                      <input type="number" class="form-control" id="saldopagar" name="saldopagar" step="0.1" readonly>
                    </div>
                  </div> -->
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="metodo_pago">Metodo de Pago</label>
                        <select name="metodo_pago" id="metodo_pago" class="form-control">
                          <option value="">- Seleccione -</option>
                          <?php foreach($listaMetodoPago as $k=>$v){ ?>
                            <option value="<?= $v['idmetodopago'] ?>"><?= $v['nombre'] ?></option>
                          <?php } ?>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="monto_pago">Monto de pago</label>
                        <input type="number" class="form-control" id="monto_pago" name="monto_pago" step="0.1" min="0">
                    </div>
                  </div>
                </div>
                <div class="form-group d-none">
                  <label for="descripcion_pago">Descripcion</label>
                  <input type="text" class="form-control" id="descripcion_pago" name="descripcion_pago" value="Servicio de hospedaje">
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarPago" ><i class="fa fa-save"></i> Registrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
  </div>

  <div class="modal fade" id="modalEmail">
  <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header bg-primary">
              <h4 class="modal-title">Enviar por email</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form name="formEmail" id="formEmail" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
	                		<label for="nombre">Email del huésped</label>
	                		<input type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" 
                      required  placeholder="Debe ser de tipo gmail.com">

	                		<input type="hidden" class="form-control" id="idtransaccionemail" name="idtransaccionemail">

	                		<!-- <input type="hidden" name="montoemail" id="montoemail" value="">
	                		<input type="hidden" name="fechaemail" id="fechaemail" value="">
	                		<input type="hidden" name="huespedemail" id="huespedemail" value="">
	                		<input type="hidden" name="responsableemail" id="responsableemail" value="">
	                		<input type="hidden" name="mpagoemail" id="mpagoemail" value="">
	                		<input type="hidden" name="habitacionemail" id="habitacionemail" value="">
	                		<input type="hidden" name="documentoemail" id="documentoemail" value=""> -->
                    </div>
            		  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-around">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
              <button type="button" class="btn bg-primary" onclick="enviarComprobante()" ><i class="fas fa-paper-plane"></i> Enviar</button>
            </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    
function verListado(){
  $("#divListadoHabitacion").html('<div class="loader"><div class="justify-content-center jimu-primary-loading"></div></div>');
    $.ajax({
      method: "POST",
      url: "vista/hospedajes_listado.php",
      data:{
        estado: $('#cboBusquedadEstado').val(),
        idtipohabitacion: $('#cboBusquedadTipoHabitacion').val(),
        habitacion: $('#txtBusquedaHabitacion').val()
      }
    })
    .done(function(resultado){
      $('#divListadoHabitacion').html(resultado);
    })
}

verListado();

/* AGREGAR HUESPED A LA HABITACION */
function guardarHospedar(){
  if(validarFormularioHospedar()){
    var datos = $('#formHospedar').serializeArray();
    var idhospedar = $('#idhospedar').val();

    if(idhospedar!=""){
      datos.push({name: "accion", value: "NUEVO_HOSPEDAR"});
    }

    $.ajax({
      method: "POST",
      url: "controlador/contHospedaje.php",
      data: datos,
      dataType: 'json'
    })
    .done(function(resultado){
      if(resultado.correcto==1){
        toastCorrecto(resultado.mensaje);
        $('#modalHospedar').modal('hide');
        $('#formHospedar').trigger('reset');
        verListado()
      }else{
        toastError(resultado.mensaje)
      }
    });
  }
}

function validarFormularioHospedar(){
  let correcto = true;
  let identificacion_hue = $('#identificacion_hue').val();
  let nom_huesped = $('#nom_huesped').val();
  let resante = $('#resante').val();
  let motviaje = $('#motviaje').val();

  $('.obligatorio').removeClass('is-invalid');

  if(nom_huesped==""){
    toastError('No esta registrando a ningun huesped');
    $('#nom_huesped').addClass('is-invalid');
    correcto = false;
  }
  if(identificacion_hue==""){
    toastError('Realice la busqueda de un huesped');
    $('#identificacion_hue').addClass('is-invalid');
    correcto = false;
  }
  if(resante==""){
    toastError('Ingrese la residencia anterior del huesped');
    $('#resante').addClass('is-invalid');
    correcto = false;
  }
  if(motviaje==""){
    toastError('Ingrese el motivo de viaje del huesped');
    $('#motviaje').addClass('is-invalid');
    correcto = false;
  }

  return correcto;
}


/* REGISTRAR NUEVO HUESPED */
function abrirModalHuesped(){
  $('#formHuesped').trigger('reset');
  $('#modalHuesped').modal('show');
  
  $('#nrodoc').removeClass('is-invalid');
  $('#nomhuesped').removeClass('is-invalid');
  $('#profesion').removeClass('is-invalid');
  $('#tipodoc').removeClass('is-invalid');
  $('#nacionalidad').removeClass('is-invalid');
  $('#fenac').removeClass('is-invalid');
}

function guardarHuesped(){
  if(validarFormularioHuesped()){
    var datos = $('#formHuesped').serializeArray();
    datos.push({name: "accion", value: "NUEVO"});

    $.ajax({
      method: "POST",
      url: "controlador/contHuesped.php",
      data: datos,
      dataType: 'json'
    })
    .done(function(resultado){
      if(resultado.correcto==1){
        toastCorrecto(resultado.mensaje);
        $('#modalHuesped').modal('hide');
        $('#formHuesped').trigger('reset');
      }else{
        toastError(resultado.mensaje)
      }
    });
  }
}

function validarFormularioHuesped(){
  let correcto = true;
  let nomhuesped = $('#nomhuesped').val();
  let profesion = $('#profesion').val();
  let nrodoc = $('#nrodoc').val();
  let tipodoc = $('#tipodoc').val();
  let nacionalidad = $('#nacionalidad').val();
  let fenac = $('#fenac').val();

  $('.obligatorio').removeClass('is-invalid');

  if(nomhuesped==""){
      toastError('Ingrese el nombre del huesped');
      $('#nomhuesped').addClass('is-invalid');
      correcto = false;
    }
    if(profesion==""){
      toastError('Ingrese la profesion del huesped');
      $('#profesion').addClass('is-invalid');
      correcto = false;
    }
    if(nrodoc==""){
      toastError('Ingrese el número de documento del huesped');
      $('#nrodoc').addClass('is-invalid');
      correcto = false;
    }
    if(tipodoc==""){
      toastError('Ingrese el tipo de documento');
      $('#tipodoc').addClass('is-invalid');
      correcto = false;
    }
    if(nacionalidad==""){
      toastError('Ingrese la nacionalidad del huesped');
      $('#nacionalidad').addClass('is-invalid');
      correcto = false;
    }
    if(fenac==""){
      toastError('Ingrese la fecha de nacimiento del huesped');
      $('#fenac').addClass('is-invalid');
      correcto = false;
    }

  return correcto;
}


/* BUSQUEDA DE HUESPED */
function buscarHuesped(){
  if(validarBusquetaHuesped()){
    $.ajax({
        method: "POST",
        url: "controlador/contHospedaje.php",
        data: {
          accion: 'CONSULTAR_HUESPED',
          idhue: $('#identificacion_hue').val()
        },
        dataType: "json"
      })
      .done(function(resultado){
        $('#nom_huesped').val(resultado.nombre);
        $('#idhuesped').val(resultado.id_hue);
        if(resultado==false){
          toastError('El huesped no existe en la base de datos');
          $('#nom_huesped').removeClass('is-valid');
        }else{
          $('#nom_huesped').removeClass('is-invalid');
          $('#nom_huesped').addClass('is-valid');
          toastCorrecto('El huesped existe en la base de datos');
        }
      });
  }    
}

function validarBusquetaHuesped(){
  let correcto = true;
  let cedula = $('#identificacion_hue').val();

  if(cedula==""){
    toastError('Ingrese un número de identificación');
    $('#identificacion_hue').addClass('is-invalid');
    correcto = false;
  }

  return correcto;
}

/* REGISTRAR PAGO POR LA HABITACION */
function guardarPago(idhospedaje){
  if(validarFormularioTransaccion()){
    var datos = $('#formTransaccion').serializeArray();
    datos.push({name: "accion", value: "NUEVO_PAGO"});

    $.ajax({
      method: "POST",
      url: "controlador/contHospedaje.php",
      data: datos,
      dataType: 'json'
    })
    .done(function(resultado){
      if(resultado.correcto==1){
        toastCorrecto(resultado.mensaje);
        $('#modalTransaccion').modal('hide');
        $('#formTransaccion').trigger('reset');
        /* Actualiza los datos del formulario datos de hospedaje */
        datosHospedaje(idhospedaje);
      }else{
        toastError(resultado.mensaje)
      }
    });
  }
}

function validarFormularioTransaccion(){
  let correcto = true;
  let metodo_pago = $('#metodo_pago').val();
  let monto_pago = $('#monto_pago').val();
  let descripcion_pago = $('#descripcion_pago').val();

  $('.obligatorio').removeClass('is-invalid');

    if(metodo_pago==""){
      toastError('Seleccione un metodo de pago');
      $('#metodo_pago').addClass('is-invalid');
      correcto = false;
    }
    if(monto_pago==""){
      toastError('Ingrese una cantidad de pago');
      $('#monto_pago').addClass('is-invalid');
      correcto = false;
    }
    if(descripcion_pago==""){
      toastError('Ingrese la descripcion del pago');
      $('#descripcion_pago').addClass('is-invalid');
      correcto = false;
    }
    

  return correcto;
}

function actualizarTiempoEstadia(){
  var idhospedaje = $('#idhospedaje').val();
  var duracionestadia = $('#duracionestadia').val();
  var observacion = $('#observacion').val();

  $.ajax({
      method: "POST",
      dataType: 'json',
      url: "controlador/contHospedaje.php",
      data:{
        idhospedaje: idhospedaje,
        duracionestadia:duracionestadia,
        observacion: observacion,
        accion:'ACTUALIZAR_ESTADIA'
      }
    })
    .done(function(resultado){
      if(resultado.correcto==1){
        toastCorrecto(resultado.mensaje);
        /* Actualiza los datos del formulario datos de hospedaje */
        datosHospedaje(idhospedaje);
      }else{
        toastError(resultado.mensaje)
      }
    });
}

function mostrarPagos(){
  var idhospedaje = $('#idhospedaje').val();

  $.ajax({
    method: "POST",
    dataType: 'json',
    url: "controlador/contHospedaje.php",
    data:{
      idhospedaje: idhospedaje,
      accion:'MOSTRAR_PAGOS'
    }
  })
  .done(function(resultado){
    $('#ListadoPagos tbody').empty();

    if (resultado.length === 0) {
      $('#ListadoPagos tbody').append(
        '<tr><td colspan="6" class="text-center">No se tiene registros</td></tr>'
      );
    } else {
      for (var i = 0; i < resultado.length; i++) {
        console.log(resultado[i]);
        $('#ListadoPagos tbody').append(
          '<tr>' +
            '<td>' + resultado[i].nombcomp + '</td>' +
            '<td>' + resultado[i].monto + '</td>' +
            '<td>' + resultado[i].metodopago + '</td>' +
            '<td>' + resultado[i].fecha + '</td>' +
            '<td>' + resultado[i].responsable + '</td>' +

            /* '<td>' + '<div class="btn-group btn-group-sm">' + '<button class="btn btn-danger btn-sm" onclick="guardarComprobante(' + resultado[i].id_huesped + ',' + resultado[i].monto + ',\'' + resultado[i].responsable + '\')" data-toggle="tooltip" title="Imprimir Comprobante"><i class="fas fa-file-pdf"></i></button>' + '<button class="btn bg-primary btn-sm" onclick="abrirModalEmail(' + resultado[i].monto + ', \'' + resultado[i].fecha + '\', \'' + resultado[i].nombcomp + '\', \'' + resultado[i].responsable + '\', \'' + resultado[i].metodopago + '\', ' + resultado[i].codigohabitacion  + ','+ resultado[i].nrodocumento + ')" data-toggle="tooltip" title="Enviar Comprobante"><i class="fas fa-envelope"></i></button>' + '</div>' + '</td>' + */
            '<td>' + '<div class="btn-group btn-group-sm">' + '<button class="btn btn-danger btn-sm" onclick="guardarComprobante(' + resultado[i].idtransaccion + ')" data-toggle="tooltip" title="Imprimir Comprobante"><i class="fas fa-file-pdf"></i></button>' + '<button class="btn bg-primary btn-sm" onclick="abrirModalEmail(' + resultado[i].idtransaccion + ')" data-toggle="tooltip" title="Enviar Comprobante"><i class="fas fa-envelope"></i></button>' + '</div>' + '</td>' +

          '</tr>'
        );
      }
    }
    $('#modalPagosHospedaje').modal('show');
  })
}

function finalizarEstadia(){

  var idhospedaje = $('#idhospedaje').val();
  var id_habitacion = $('#id_habitacionhos').val();
  var saldopagar = parseFloat($('#idhospedaje_saldopagar').val());


  $.ajax({
    method: "POST",
    url: "controlador/contHospedaje.php",
    data: {
      accion: 'VERIFICAR_HUESPEDES_EXISTEN',
      idhospedaje: idhospedaje
    },
    dataType: "json"
  })
  .done(function(resultado){
    if (saldopagar!==0) {
      toastError("Existe un saldo pendiente por pagar")
    } else {
      if (resultado.length === 0) {
        cambiarEstadoHospedaje(idhospedaje, 1, id_habitacion)
        $('#modalHuespedes_habitacion').modal('hide');
      }else{
        toastError("Existen huespedes en la habitacion")
      }
    }
  });    	

}


function guardarComprobante(idtransaccion){

      window.open("fpdf/comprobantePago.php?idt=" + idtransaccion);

      $('#modalComprobante').modal('hide');
  }

/*   function abrirModalEmail(monto,fecha,huesped,responsable,netodopago,codigohabitacion,nrodocumento){

    $('#formEmail').trigger('reset');
    $('#montoemail').val(monto);
    $('#fechaemail').val(fecha);
    $('#huespedemail').val(huesped);
    $('#responsableemail').val(responsable);
    $('#mpagoemail').val(netodopago);
    $('#habitacionemail').val(codigohabitacion);
    $('#documentoemail').val(nrodocumento);

    $('#modalEmail').modal('show');
  }

  function enviarComprobante(){
    var email = $('#email').val();
    var monto =  $('#montoemail').val();
    var fecha =  $('#fechaemail').val();
    var huesped =  $('#huespedemail').val();
    var responsable =  $('#responsableemail').val();
    var metodopago =  $('#mpagoemail').val();
    var habitacion =  $('#habitacionemail').val();
    var nrodocumento =  $('#documentoemail').val();

    $.ajax({
      method: "POST",
      url: "fpdf/comprobantePhpMailer.php",
      data: {
        email: email,
        monto: monto,
        fecha: fecha,
        huesped: huesped,
        responsable: responsable,
        metodopago: metodopago,
        habitacion: habitacion,
        nrodocumento: nrodocumento
      }
    })
    .done(function(resultado){
      $('#modalEmail').modal('hide');
      toastCorrecto('Comprobante enviado exitosamente');
    }); 

  } */
  function abrirModalEmail(idtransaccion){

  $('#formEmail').trigger('reset');
  $('#idtransaccionemail').val(idtransaccion);
  $('#email').removeClass('is-invalid');


  $('#modalEmail').modal('show');
}

function enviarComprobante(){
  if(validarEmail()){
  var email = $('#email').val();
  var idtransaccion =  $('#idtransaccionemail').val();

  $('#modalEmail').modal('hide');
  $.ajax({
      method: "POST",
      url: "fpdf/comprobantePhpMailer.php",
      data: {
        email: email,
        idtransaccion: idtransaccion
      },
      dataType: "json" 
    }).done(function(resultado) {
        if (resultado.success) {
              toastCorrecto(resultado.message); 
        } else {
            toastError(resultado.message); 
        }
    });
  }
}

  function validarEmail(){
    let correcto = true;
    let email = $('#email').val();

    $('.obligatorio').removeClass('is-invalid');

    if(email==""){
      toastError('Ingrese una dirección de correo');
      $('#email').addClass('is-invalid');
      correcto = false;
    }else{
        const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

        if (!emailPattern.test(email)) {
            toastError("Ingresa un correo que termine en @gmail.com");
            $('#email').addClass('is-invalid');
           correcto = false;
        }
    }

    return correcto;
  }



</script>




