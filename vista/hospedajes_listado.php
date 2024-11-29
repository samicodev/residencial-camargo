<?php
require_once('../modelo/clsHospedaje.php');

$objHospedaje = new clsHospedaje();

$estado = $_POST['estado'];
$idtipohabitacion = $_POST['idtipohabitacion'];
$habitacion = $_POST['habitacion'];

$listaHabitacion = $objHospedaje->listarHabitacion($habitacion,  $idtipohabitacion, $estado);
$listaHabitacion = $listaHabitacion->fetchAll(PDO::FETCH_NAMED);

usort($listaHabitacion, function ($a, $b) {
	return $a['codigohabitacion'] - $b['codigohabitacion'];
});

$listarHospedaje = $objHospedaje->listarHospedaje();
$listarHospedaje = $listarHospedaje->fetchAll(PDO::FETCH_NAMED);

$listarNumeroHospedaje = $objHospedaje->listarNumeroHospedaje();
$listarNumeroHospedaje = $listarNumeroHospedaje->fetchAll(PDO::FETCH_NAMED);

?>

<div class="container-fluid">
	<div class="row">
		<?php if (!empty($listaHabitacion)) { ?>
			<?php foreach ($listaHabitacion as $key => $valor) { ?>
				<?php
				if ($valor['estadohabitacion'] == 0) {
					$bgclass = "bg-info";
				} elseif ($valor['estadohabitacion'] == 1) {
					$bgclass = "bg-success";
				} elseif ($valor['estadohabitacion'] == 2) {
					$bgclass = "bg-maroon";
				}
				?>
				<div class="col-lg-3 col-6">
					<div class="small-box <?= $bgclass; ?>">
						<div class="inner">
							<h3>Nro. <?= $valor['codigohabitacion']; ?></h3>
							<p><?= $valor['nombre_tipohabitacion']; ?></p>
						</div>
						<div class="icon">
							<i class="fas fa-bed"></i>
						</div>
						<div class="small-box-footer">

							<?php foreach ($listarNumeroHospedaje as $numero_hospedaje) { ?>
								<?php if ($numero_hospedaje['id_habitacion'] == $valor['id_habitacion']) { ?>
									<button type="button" class="btn btn-sm btn-default" onclick="datosHospedaje(<?= $numero_hospedaje['id_hospedaje'] ?>)" data-toggle="tooltip" title="VER HÚESPEDES">
										<i class="fas fa-eye"></i>
									</button>
								<?php } ?>
							<?php } ?>

							<?php
							$hospedaje_iniciado = false;
							foreach ($listarHospedaje as $hospedaje) {
								if ($hospedaje['id_habitacion'] == $valor['id_habitacion']) {
									$hospedaje_iniciado = true;
									break; 
								}
							}

							if (!$hospedaje_iniciado && $valor['estadohabitacion'] == 0) { ?>
								<button type="button" class="btn btn-default btn-sm" onclick="cambiarEstadoHospedaje(<?= $valor['id_habitacion'] ?>,0)" data-toggle="tooltip" title="INICIAR HOSPEDAJE" id="iniciarhospedaje">
									<i class="fas fa-calendar-plus"></i>
								</button>
							<?php } ?>
							
							<?php if ($valor['estadohabitacion'] == 2) { ?>
								<button type="button" class="btn btn-default btn-sm" onclick="cambiarEstadoHabitacion(<?= $valor['id_habitacion'] ?>,0)" data-toggle="tooltip" title="FINALIZAR LIMPIEZA" id="finalizarLimpieza">
									<i class="fas fa-hand-sparkles"></i>
								</button>
							<?php } ?>

							<?php foreach ($listarHospedaje as $hospedaje) { ?>
								<?php if ($hospedaje['id_habitacion'] == $valor['id_habitacion']) { ?>
									<button type="button" class="btn btn-default btn-sm" onclick="abrirModalHospedaje(<?= $hospedaje['id_hospedaje'] ?>)" data-toggle="tooltip" title="AGREGAR HUÉSPED">
										<i class="fas fa-user-plus"></i>
									</button>
								<?php } ?>
							<?php } ?>

						</div>
					</div>
				</div>
			<?php } ?>
		<?php } else { ?>
			<div class="alert alert-info col-md-12">
				<h5><i class="icon fas fa-info"></i> No se tiene registros.</h5>
			</div>
		<?php } ?>
	</div>

</div>

<script>
	/* AGREGAR HUESPED A LA HABITACION */
	function abrirModalHospedaje(idhospedaje) {
		$('#formHospedar').trigger('reset');
		$('#idhospedar').val(idhospedaje);
		$('#modalHospedar').modal('show');

		$('.obligatorio').removeClass('is-invalid');
		$('#nom_huesped').removeClass('is-invalid');
		$('#identificacion_hue').removeClass('is-invalid');
		$('#resante').removeClass('is-invalid');
		$('#motviaje').removeClass('is-invalid');

		$('#nom_huesped').removeClass('is-valid');
		$('#idhuesped').val('');
	}

	/* MOSTRAR DATOS DEL HOSPEDAJE */
	function datosHospedaje(idhospedaje) {
		$.ajax({
				method: "POST",
				url: "controlador/contHospedaje.php",
				data: {
					accion: 'CONSULTAR_DATOS_HOSPEDAJE',
					idhospedaje: idhospedaje
				},
				dataType: "json"
			})
			.done(function(resultado) {
				$('#idhospedaje').val(idhospedaje);
				$('#id_habitacionhos').val(resultado.id_habitacion);
				$('#idhospedaje_saldopagar').val(resultado.saldopendiente);
				$('#fechainicio').val(resultado.fechainicio);
				$('#numerohabitacion').val(resultado.numerohabitacion);
				$('#tipohabitacion').val(resultado.tipohabitacion);
				$('#preciohabitacion').val(resultado.preciohabitacion);
				$('#duracionestadia').val(resultado.diashospedaje);
				$('#costototal').val(resultado.costototal);
				$('#totalpagado').val(resultado.totalpagado);
				$('#porpagar').val(resultado.saldopendiente);
				$('#observacion').val(resultado.observacionhospedaje);

				/* $('#modalHuespedes_habitacion').modal('show'); */
				listarHuespedes(idhospedaje)
			});
	}

	/* MOSTRAR LOS HUESPEDES DE LA HABITACION */
	function listarHuespedes(idhospedaje) {
		$.ajax({
				method: "POST",
				url: "controlador/contHospedaje.php",
				data: {
					accion: 'CONSULTAR_HUESPEDES',
					idhospedaje: idhospedaje
				},
				dataType: "json"
			})
			.done(function(resultado) {
				$('#ListadoHuespedes tbody').empty();
				// Asigna la cantidad de huéspedes al input
				$('#cantidadHuespedes').val(resultado.length);

				if (resultado.length === 0) {
					$('#ListadoHuespedes tbody').append(
						'<tr><td colspan="6" class="text-center">No se tiene registros</td></tr>'
					);
				} else {
					for (var i = 0; i < resultado.length; i++) {
						$('#ListadoHuespedes tbody').append(
							'<tr>' +
							'<td>' + resultado[i].nombcomp + '</td>' +
							'<td>' + resultado[i].nrodocumento + '</td>' +
							'<td>' + resultado[i].nacionalidad + '</td>' +
							'<td>' + resultado[i].edad + '</td>' +
							'<td>' + resultado[i].resante + '</td>' +
							'<td>' + '<div class="btn-group btn-group-sm">' + '<button class="btn btn-danger btn-sm" onclick="finalizarEstadiaHuesped(' + resultado[i].id_hospedar + ',' + idhospedaje + ')" data-toggle="tooltip" title="MARCAR FIN DE ESTADIA"><i class="fa fa-user-minus"></i></button>' + '<button class="btn btn-success btn-sm" onclick="abrirModalTransaccion(' + resultado[i].id_hospedar + ',' + idhospedaje + ', \'' + resultado[i].nombcomp + '\', ' + resultado[i].id_huesped + ')" data-toggle="tooltip" title="REGISTRAR PAGO"><i class="fa fa-hand-holding-usd"></i></button>' + '</div>' + '</td>' +
							'</tr>'
						);
					}
				}
				
				$('#modalHuespedes_habitacion').modal('show');
			});
	}

	/* MARCAR SALIDA DE HUESPED */
	function finalizarEstadiaHuesped(idhospedar, idhospedaje) {
		var saldopagar = parseFloat($('#idhospedaje_saldopagar').val());
		var cantidadHuespedes = parseInt($('#cantidadHuespedes').val());

		/* console.log(saldopagar);
		console.log(cantidadHuespedes); */

		if(cantidadHuespedes>1){
			//Puedo finalizar estadia
			$.ajax({
					method: "POST",
					url: "controlador/contHospedaje.php",
					data: {
						accion: 'FINALIZAR_ESTADIA_HUESPED',
						idhospedar: idhospedar,
						idhospedaje: idhospedaje
					},
					dataType: "json"
				})
				.done(function(resultado) {
					if (resultado.correcto == 1) {
						/* $('#modalHuespedes_habitacion').modal('hide'); */
						listarHuespedes(idhospedaje)
						toastCorrecto(resultado.mensaje);
					} else {
						toastError(resultado.mensaje)
					}
				});
		}else{
			if(saldopagar==0){
				//Puedo finalizar estadia
				$.ajax({
					method: "POST",
					url: "controlador/contHospedaje.php",
					data: {
						accion: 'FINALIZAR_ESTADIA_HUESPED',
						idhospedar: idhospedar,
						idhospedaje: idhospedaje
					},
					dataType: "json"
				})
				.done(function(resultado) {
					if (resultado.correcto == 1) {
						/* $('#modalHuespedes_habitacion').modal('hide'); */
						listarHuespedes(idhospedaje)
						toastCorrecto(resultado.mensaje);
					} else {
						toastError(resultado.mensaje)
					}
				});
			}else{
				toastError("Existe un saldo pendiente por pagar")
			}
		}

		/* if (saldopagar>0 && cantidadHuespedes>1) {
			$.ajax({
					method: "POST",
					url: "controlador/contHospedaje.php",
					data: {
						accion: 'FINALIZAR_ESTADIA_HUESPED',
						idhospedar: idhospedar,
						idhospedaje: idhospedaje
					},
					dataType: "json"
				})
				.done(function(resultado) {
					if (resultado.correcto == 1) {
						listarHuespedes(idhospedaje)
						toastCorrecto(resultado.mensaje);
					} else {
						toastError(resultado.mensaje)
					}
				});
		}else{
      toastError("No se puede finalizar la estadia")
		} */
	}

	/* INCIAR o FINALIZAR HOSPEDAJE */
	function cambiarEstadoHospedaje(id, estado, idhabitacion) {
		proceso = new Array('INICIAR', 'FINALIZAR');
		mensaje = "¿Esta Seguro de <b>" + proceso[estado] + "</b> el hospedaje?";

		if (estado == 0) {
			accion = "iniciarHospedaje(" + id + ")";
		} else if (estado == 1) {
			accion = "finalizarHospedaje(" + id + ", " + idhabitacion + ")";
		}

		mostrarModalConfirmacion(mensaje, accion);
	}

	function iniciarHospedaje(id) {
		$.ajax({
				method: "POST",
				url: "controlador/contHospedaje.php",
				data: {
					accion: 'INICIAR_HOSPEDAJE',
					idhabitacion: id
				},
				dataType: "json"
			})
			.done(function(resultado) {
				if (resultado.correcto == 1) {
					toastCorrecto(resultado.mensaje);
					verListado()
				} else {
					toastError(resultado.mensaje)
				}
			});
	}

	/* CAMBIAR ESTADO HABITACION */
	function cambiarEstadoHabitacion(id) {
		mensaje = "¿Esta Seguro de que ha <b>" + 'CONCLUIDO' + "</b> la limpieza?";

		accion = "cambiarEstado(" + id + ")";

		mostrarModalConfirmacion(mensaje, accion);
	}

	function cambiarEstado(id) {
		$.ajax({
				method: "POST",
				url: "controlador/contHospedaje.php",
				data: {
					accion: 'CAMBIAR_ESTADO_HABITACION',
					idhabitacion: id
				},
				dataType: "json"
			})
			.done(function(resultado) {
				if (resultado.correcto == 1) {
					toastCorrecto(resultado.mensaje);
					verListado()
				} else {
					toastError(resultado.mensaje)
				}
			});
	}

	function finalizarHospedaje(id, idhabitacion) {
		$.ajax({
				method: "POST",
				url: "controlador/contHospedaje.php",
				data: {
					accion: 'FINALIZAR_HOSPEDAJE',
					idhospedaje: id,
					idhabitacion: idhabitacion
				},
				dataType: "json"
			})
			.done(function(resultado) {
				if (resultado.correcto == 1) {
					toastCorrecto(resultado.mensaje);
					verListado()
				} else {
					toastError(resultado.mensaje)
				}
			});
	}

	/* REGISTRAR PAGO POR LA HABITACION */
	function abrirModalTransaccion(idhospedar, idhospedaje, nombcomp, idhuesped, costotoal, saldopendiente) {
		$('#formTransaccion').trigger('reset');
		$('#idhospedar_pago').val(idhospedar);
		$('#idhospedaje_pago').val(idhospedaje);
		$('#idhuesped_pago').val(idhuesped);
		$('#nomhuesped_pago').val(nombcomp);
		$('#costotoal').val(costotoal);
		$('#saldopagar').val(saldopendiente);

		$('#metodo_pago').removeClass('is-invalid');
		$('#monto_pago').removeClass('is-invalid');
		$('#descripcion_pago').removeClass('is-invalid');

		$('#modalTransaccion').modal('show');

		/* Llama a guardarPago con idhospedaje para luego acualizar los datos */
		$('#guardarPago').off('click').on('click', function() {
			guardarPago(idhospedaje);
		});
	}
</script>