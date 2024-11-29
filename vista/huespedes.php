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
        <h3 class="card-title">Listado de Huespedes</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
          </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nombre</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaNombre" id="txtBusquedaNombre" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nacionalidad</span>
              </div>
              <input type="text" class="form-control" name="txtBusquedaNacionalidad" id="txtBusquedaNacionalidad" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Nro de Doc.</span>
              </div>
              <input type="nunber" class="form-control" name="txtBusquedaNroDoc" id="txtBusquedaNroDoc" onkeyup="if(event.keyCode=='13'){ verListado(); }" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Tipo de Doc.</span>
              </div>
              <select class="form-control" name="cboBusquedadTipoDoc" id="cboBusquedadTipoDoc" onchange="verListado()">
                <option value="">- Todos -</option>
                <?php foreach($listaTipoDocumento as $k=>$v){ ?>
                <option value="<?= $v['id_tipodocumento'] ?>"><?= $v['nombre'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Fecha de Nacimiento</span>
              </div>
              <input type="date" class="form-control " name="BusquedaFeNac" id="BusquedaFeNac" onchange="verListado()" >
            </div>
          </div>
          <div class="col-md-3 d-none">
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
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
              <button type="button" class="btn btn-success" onclick="abrirModalHuesped()"><i class="fas fa-plus-circle"></i> Nuevo</button>
            </div>
        </div>
      </div>
    </div>
    <div class="card card-success">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="divListadoHuesped">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
                      <input type="hidden" name="idhuesped" id="idhuesped" value="">
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
    <!-- /.modal-dialog -->
</div>


<script>
    
function verListado(){
    $("#divListadoHuesped").html('<div class="loader"><div class="justify-content-center jimu-primary-loading"></div></div>');
    $.ajax({
      method: "POST",
      url: "vista/huespedes_listado.php",
      data:{
        nroDoc: $('#txtBusquedaNroDoc').val(),
        tipoDoc: $('#cboBusquedadTipoDoc').val(),
        BsqFeNac: $('#BusquedaFeNac').val(),
        BsqFeNomb: $('#txtBusquedaNombre').val(),
        BsqFeNacion: $('#txtBusquedaNacionalidad').val(),
        estado: $('#cboBusquedadEstado').val()
      }
    })
    .done(function(resultado){
      $('#divListadoHuesped').html(resultado);
    })
  }

  verListado();

  function guardarHuesped(){
    if(validarFormulario()){
      var datos = $('#formHuesped').serializeArray();
      var idhuesped = $('#idhuesped').val();
      if(idhuesped!=""){
        datos.push({name: "accion", value: "ACTUALIZAR"});
      }else{
        datos.push({name: "accion", value: "NUEVO"});
      }

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
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
    }
  }

  function validarFormulario(){
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

  function abrirModalHuesped(){
      $('#formHuesped').trigger('reset');
      $('#idhuesped').val("");
      $('#modalHuesped').modal('show');

      $('#nrodoc').removeClass('is-invalid');
      $('#nomhuesped').removeClass('is-invalid');
      $('#profesion').removeClass('is-invalid');
      $('#tipodoc').removeClass('is-invalid');
      $('#nacionalidad').removeClass('is-invalid');
      $('#fenac').removeClass('is-invalid');
  }


</script>