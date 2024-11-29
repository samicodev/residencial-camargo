<?php
require_once('conexion.php');

class clsDashboard{

	function listarTargetas(){
		$sql = "SELECT
    (SELECT COUNT(*) FROM tipohabitacion) AS totaltipohabitacion,
    (SELECT COUNT(*) FROM habitacion) AS totalhabitacion,
    (SELECT COUNT(*) FROM huesped) AS totalhuesped,
    (SELECT COUNT(*) FROM hospedaje) AS totalhospedaje;";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute();
		return $pre;
	}

	function consultarReservas(){
		$sql = "SELECT hue.nombcomp AS 'title', hos.fechaingreso AS 'start', hos.fechasalida AS 'end', hos.observacion, CONCAT_WS(' -- ',DATE_FORMAT(DATE(hos.fechaingreso), '%d/%m'),DATE_FORMAT(DATE(hos.fechasalida), '%d/%m')) AS 'fechareserva'
		FROM huesped hue
		INNER JOIN hospedaje hos
		ON hue.id_huesped=hos.id_huesped
		WHERE hos.fechaingreso>NOW()";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute();
		return $pre;
	}

	function consultarCalendar(){
		$sql = "SELECT hue.nombcomp AS 'title', hos.fechaingreso AS 'start', hos.fechasalida AS 'end'
		FROM huesped hue
		INNER JOIN hospedaje hos
		ON hue.id_huesped=hos.id_huesped
		WHERE hos.fechaingreso>NOW()";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute();
		return $pre;
	}


}
?>