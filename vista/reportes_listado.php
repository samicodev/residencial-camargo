<?php
	require_once('../modelo/clsReporte.php');

	$objReporte = new clsReporte();

	$habitacion = $_POST['habitacion'];
	$nrodoc = $_POST['nrodoc'];
	$fechaingreso = $_POST['fechaingreso'];
	$fechasalida = $_POST['fechasalida'];
	$fecharango = $_POST['fecharango'];
	
	$listaReporte = $objReporte->listarReporte($habitacion,$nrodoc,$fechaingreso,$fechasalida, $fecharango);
	$listaReporte = $listaReporte->fetchAll(PDO::FETCH_NAMED);

?>

<table id="tableReporte" class="table table-bordered table-striped">
	<thead class="bg-lightblue text-sm">
		<tr>
			<th>COD</th>
			<th>NOMBRE Y APELLIDOS</th>
			<th>NACIONALIDAD</th>
			<th>NRO DOC.</th>
			<th>NRO HAB.</th>
			<th>FECHA DE INGRESO</th>
			<th>FECHA DE SALIDA</th>
			<th>PROCEDENCIA</th>
			<th>MOTIVO DE VIAJE</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listaReporte as $key => $value) {

		?>
		<tr class="<?= $class ?>">
			<td><?= $value['id_hospedar'] ?></td>
			<td><?= $value['huesped'] ?></td>
			<td><?= $value['nacionalidad'] ?></td>
			<td><?= $value['nrodocumento'] ?></td>
			<td><?= $value['habitacion'] ?></td>
			<td><?= $value['fechaingreso'] ?></td>
			<td>
				<?php if($value['fechasalida']==NULL){ 
					echo 'Sin finalizar';
				}else{
					echo $value['fechasalida'];
				 }
				 ?>
			</td>
			<td><?= $value['resante'] ?></td>
			<td><?= $value['motviaje'] ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$("#tableReporte").DataTable({
    	"responsive": true, 
    	"lengthChange": true, 
    	"autoWidth": false,
    	"searching": false,
    	"ordering": true,
			"order": [[0, "asc"]],
    	//Mantener la Cabecera de la tabla Fija
    	// "scrollY": '200px',
        // "scrollCollapse": true,
        // "paging": false,
    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
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


</script>