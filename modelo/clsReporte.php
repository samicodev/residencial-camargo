<?php
require_once('conexion.php');

class clsReporte{

	function listarReporte($habitacion,$nrodoc,$fechaingreso,$fechasalida, $fecharango){
		$sql = "SELECT hospe.id_hospedaje, hue.nombcomp as 'huesped', DATE_FORMAT(hue.fenac, '%d/%m/%Y') as 'fechnac', hue.nacionalidad, hue.nrodocumento, hab.codigohabitacion as 'habitacion',
		 hos.id_hospedar, DATE_FORMAT(hos.fechaingreso, '%d/%m/%Y  %h:%i %p') as 'fechaingreso',
		  DATE_FORMAT(hos.fechasalida, '%d/%m/%Y  %h:%i %p') as 'fechasalida', hos.resante, hos.motviaje, hos.estado
		FROM hospedar hos 
		INNER JOIN huesped hue 
		ON hos.id_huesped=hue.id_huesped
		INNER JOIN hospedaje hospe
		ON hos.id_hospedaje=hospe.id_hospedaje
		INNER JOIN habitacion hab 
		ON hospe.id_habitacion=hab.id_habitacion        
		WHERE hue.estado=1 AND hos.estado=1";
		$parametros = array();

		if($habitacion!=""){
			$sql .= " AND hab.codigohabitacion LIKE :codigohabitacion ";
			$parametros[':codigohabitacion'] = "%".$habitacion."%";
		}

		if($nrodoc!=""){
			$sql .= " AND hue.nrodocumento LIKE :nrodoc ";
			$parametros[':nrodoc'] = "%".$nrodoc."%";
		}


		if($fechaingreso!=""){
			$sql .= " AND DATE(hos.fechaingreso) = :fechaingreso ";
			$parametros[':fechaingreso'] = $fechaingreso;
		}

		if($fechasalida!=""){
			$sql .= " AND DATE(hos.fechasalida) = :fechasalida ";
			$parametros[':fechasalida'] = $fechasalida;
		}

		if($fecharango!=""){
			$fechas = explode(' - ', $fecharango);

			$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
			$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

			$sql .= " AND DATE(hospe.fechainicio) BETWEEN :fechainicio AND :fechafin";
			$parametros[':fechainicio'] = $fechaInicio;
			$parametros[':fechafin'] = $fechaFin;
		}

		$sql .= " ORDER BY hospe.id_hospedaje ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}
}
?>