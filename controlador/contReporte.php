<?php
require_once('../modelo/clsReporte.php');

controlador($_POST['accion']);

function controlador($accion){
	$objReporte = new clsReporte();

	switch ($accion) {
		case 'NUEVO':
			
			break;

		/*  */
		
		default:
			echo "No ha definido una accion";
			break;
	}

}

?>