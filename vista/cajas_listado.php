<?php
	require_once('../modelo/clsCaja.php');

	$objCaja = new clsCaja();

	$fechaapertura = $_POST['fechaapertura'];
	$fechacierre = $_POST['fechacierre'];
	$estado = 1;

	$listaCaja = $objCaja->listarCaja($fechaapertura, $fechacierre, $estado);
	$listaCaja = $listaCaja->fetchAll(PDO::FETCH_NAMED);


?>
<table id="tableHuesped" class="table table-bordered table-striped">
	<thead class="bg-lightblue">
		<tr>
			<th>COD</th>
			<th>FECHA APERTURA</th>
			<th>FECHA CIERRE</th>
			<th>SALDO INICIAL</th>
			<th>SALDO DE TRANSACCIONES</th>
			<th>SALDO FINAL</th>
			<th>OBSERVACION</th>
			<th>OPCIONES</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaCaja as $key => $value) { 
			$class = "";
			$tdclass = "";
			if($value['estado']==0){
				$class = "text-red";
				$tdclass = "bg-danger";
			}

			$fechatdclass = "";
			if($value['fechacierre']==null){
				$fechatdclass = "bg-success";
			}
		?>
		<tr class="<?= $class ?>">
			<td><?= $value['idcaja'] ?></td>
			<td><?= $value['fechaapertura'] ?></td>
			<td class="<?= $fechatdclass; ?>">
				<?php
					if($value['fechacierre']==null){
						echo "En curso";
					}else{
						echo $value['fechacierre'];
					}
				?>	
			</td>
			<td><?= $value['saldoinicial'] ?></td>
			<td>
				<?= $value['totaltransacciones'] ?>
			</td>
			<td><?= $value['saldofinal'] ?></td>
			<td>
				<?php
					if($value['observacion']==null){
						echo "Sin observación";
					}else{
						echo $value['observacion'];
					}
				?>		
			</td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-info btn-flat btn-sm">Opciones</button>
					<button type="button" class="btn btn-info btn-flat dropdown-toggle dropdown-icon btn-sm" data-toggle="dropdown">
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div class="dropdown-menu" role="menu">
						<?php if($value['fechacierre']==null){ ?>
							<a class="dropdown-item" href="#" onclick="editarCaja(<?= $value['idcaja'] ?>)"><i class="fa fa-edit"></i> Editar</a>
						<?php } ?>
						<?php if($value['fechacierre']==null){ ?>
							<a class="dropdown-item" href="#" onclick="abrirModalEgreso(<?= $value['idcaja'] ?>)"><i class="fas fa-hand-holding-usd"></i> Egreso</a>
						<?php } ?>
						<a class="dropdown-item" href="#" onclick="listarTransacciones(<?= $value['idcaja'] ?>)"><i class="fa fa-eye"></i> Transacciones</a>
						<a class="dropdown-item" href="fpdf/reporteCaja.php?id=<?= $value['idcaja'] ?>" target="__blank"><i class="fa fa-file-pdf"></i> Reporte</a>
						<?php if($value['fechacierre']==null){ ?>
							<a class="dropdown-item" href="#" onclick="cambiarEstadoCaja(<?= $value['idcaja'] ?>)"><i class="fas fa-money-check"></i> Cerrar</a>
						<?php } ?>
					</div>
        </div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$("#tableHuesped").DataTable({
    	"responsive": true, 
    	"lengthChange": true, 
    	"autoWidth": false,
    	"searching": false,
    	"ordering": true,
			"order": [[0, "desc"]],
    	//Mantener la Cabecera de la tabla Fija
    	// "scrollY": '200px',
        // "scrollCollapse": true,
        // "paging": false,
    	"lengthMenu": [[5, 15, 50, 100, -1], [5, 15, 50, 100, "Todos"]],
    	"language": {
			"decimal":        "",
		    "emptyTable":     "No se tiene registros",
		    "info":           "Del _START_ al _END_ de _TOTAL_ filas",
		    "infoEmpty":      "Del 0 a 0 de 0 filas",
		    "infoFiltered":   "(filtro de _MAX_ filas totales)",
		    "infoPostFix":    "",
		    "thousands":      ",",
		    "lengthMenu":     "Ver _MENU_ filas",
		    "loadingRecords": "Cargando...",
		    "processing":     "Procesando...",
		    "search":         "Buscar:",
		    "zeroRecords":    "No se encontraron resultados",
		    "paginate": {
		        "first":      "Primero",
		        "last":       "Ultimo",
		        "next":       "Siguiente",
		        "previous":   "Anterior"
		    },
		    "aria": {
		        "sortAscending":  ": orden ascendente",
		        "sortDescending": ": orden descendente"
		    }
			},
    	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });

    function editarCaja(id){
    	$.ajax({
    		method: "POST",
    		url: "controlador/contCaja.php",
    		data: {
    			accion: 'CONSULTAR_CAJA',
    			idcaja: id
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
	    	$('#idcaja').val(id);
    		$('#saldoinicial').val(resultado.saldoinicial);
    		$('#observacion').val(resultado.observacion);

				$('#saldoinicial').prop('disabled', true);
				$('#modalCaja').modal('show');
    	});    	
    }

    function cambiarEstadoCaja(idcaja, estado){
    	proceso = new Array('ANULAR','ACTIVAR','ELIMINAR');
    	mensaje = "¿Esta Seguro de <b>"+proceso[estado]+"</b> el registro de la caja?";
    	accion = "EjecutarCambiarEstadoCaja("+idcaja+","+estado+")";

    	mostrarModalConfirmacion(mensaje, accion);

    }

    function EjecutarCambiarEstadoCaja(idcaja,estado){
    	$.ajax({
    		method: 'POST',
    		url: 'controlador/contCaja.php',
    		data:{
    			'accion': 'CAMBIAR_ESTADO_CAJA',
    			'idcaja': idcaja,
    			'estado': estado
    		},
    		dataType: 'json'
    	})
    	.done(function(resultado){
    		if(resultado.correcto==1){
    			toastCorrecto(resultado.mensaje);
    			verListado();
    		}else{
    			toastError(resultado.mensaje);
    		}
    	});
    }


	/* MOSTRAR LAS TRANSACCIONES EN LA CAJA */
	function listarTransacciones(idcaja){

			$('#idcajatransaccion').val(idcaja);

    	$.ajax({
    		method: "POST",
    		url: "controlador/contCaja.php",
    		data: {
    			accion: 'CONSULTAR_TRANSACCIONES',
    			idcaja: idcaja
    		},
    		dataType: "json"
    	})
    	.done(function(resultado){
				console.log(resultado);
				$('#ListadoTransacciones tbody').empty();

				if (resultado.length === 0 ) {
					$('#ListadoTransacciones tbody').append(
							'<tr><td colspan="7" class="text-center">No se tiene registros</td></tr>'
					);
				} else {
					let hayRegistrosValidos = resultado.some(item => item.idusuario != null); // Verifica si hay al menos un idusuario que no sea null

					if (!hayRegistrosValidos) {
							$('#ListadoTransacciones tbody').append(
									'<tr><td colspan="7" class="text-center">No se tiene registros</td></tr>'
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
						
				}
				
			
				$('#BusqFechIni').val('')
				$('#BusqFechFin').val('')
				$('#BusqFechIni').removeClass('is-invalid');
				$('#BusqFechFin').removeClass('is-invalid');
				$('#modalTransacciones').modal('show');
    	});
  }


		/* CERRAR CAJA */
	function cambiarEstadoCaja(id) {
		mensaje = "¿Esta Seguro de <b> Cerrar </b> la caja?";

		accion = "cerrarCaja("+id+")";

		mostrarModalConfirmacion(mensaje, accion);
	}

	function cerrarCaja(idcaja) {
		$.ajax({
				method: "POST",
				url: "controlador/contCaja.php",
				data: {
					accion: 'CERRAR_CAJA',
					idcaja: idcaja
				},
				dataType: "json"
			})
      .done(function(resultado){
        if(resultado.correcto==1){
          toastCorrecto(resultado.mensaje);
          verListado()
        }else{
          toastError(resultado.mensaje)
        }
      });
	}

	
</script>