<?php
require_once('conexion.php');

class clsResumen{

	function listarHabitacion($habitacion, $idtipohabitacion, $estado){
		$sql = "SELECT hab.*, tipohab.nombre as 'nombre_tipohabitacion' FROM habitacion hab INNER JOIN tipohabitacion tipohab ON hab.id_tipohabitacion=tipohab.id_tipohabitacion WHERE hab.estado<2 AND tipohab.estado<2";
		$parametros = array();

		if($habitacion!=""){
			$sql .= " AND hab.codigohabitacion LIKE :codigohabitacion ";
			$parametros[':codigohabitacion'] = "%".$habitacion."%";
		}

		if($idtipohabitacion!=""){
			$sql .= " AND hab.id_tipohabitacion = :id_tipohabitacion ";
			$parametros[':id_tipohabitacion'] = $idtipohabitacion; 
		}

		if($estado!=""){
			$sql .= " AND hab.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hab.codigohabitacion ASC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarHabitacion($codigo,$idTipoHabitacion,$estado){
		$sql = "INSERT INTO habitacion(codigohabitacion, id_tipohabitacion, estado) VALUES(:codigohabitacion, :id_tipohabitacion, :estado)";
		$parametros = array(
			":codigohabitacion"=>$codigo, 
			":id_tipohabitacion"=>$idTipoHabitacion, 
			":estado"=>$estado
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($codigo, $id_habitacion=0){
		$sql = "SELECT * FROM habitacion WHERE estado<2 AND codigohabitacion=:codigo AND id_habitacion<>:id_habitacion";
		$parametros = array(":codigo"=>$codigo, ":id_habitacion"=>$id_habitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHabitacion($idhabitacion){
		$sql = "SELECT * FROM habitacion WHERE id_habitacion=:idhabitacion ";
		$parametros = array(":idhabitacion"=>$idhabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHabitacion($idhabitacion, $codigo,$idTipoHabitacion,$estado){
		$sql = "UPDATE habitacion SET codigohabitacion=:codigo, id_tipohabitacion=:idTipoHabitacion, estado=:estado WHERE id_habitacion=:idhabitacion";
		$parametros = array(
			":codigo"=>$codigo, 
			":idTipoHabitacion"=>$idTipoHabitacion, 
			":estado"=>$estado, 
			":idhabitacion"=>$idhabitacion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHabitacion($idhabitacion, $estado){
		$sql = "UPDATE habitacion SET estado=:estado WHERE id_habitacion=:idhabitacion";
		$parametros = array(":estado"=>$estado, ":idhabitacion"=>$idhabitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS NUEVOS HUESPEDES POR RANGO DE FECHA */
	function mostrarHuespedesNuevos($BusqDatosRango){
		$sql = "SELECT COUNT(*) as 'nuevoshuespedes'
			FROM huesped
			WHERE fecharegistro BETWEEN :fechainicio AND :fechafin";

		$parametros = array();

		if ($BusqDatosRango != "") {
				$fechas = explode(' - ', $BusqDatosRango);

				$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
				$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

				// Asignar los parámetros de fecha
				$parametros[':fechainicio'] = $fechaInicio;
				$parametros[':fechafin'] = $fechaFin;
		}


		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS HOSPEDAJES REALIZADOS POR RANGO DE FECHA */
	function mostrarHospedajesRealizados($BusqDatosRango){
		$sql = "SELECT COUNT(*) as 'hospedajesrealizados'
			FROM hospedaje
			WHERE fechainicio BETWEEN :fechainicio AND :fechafin";

		$parametros = array();

		if ($BusqDatosRango != "") {
				$fechas = explode(' - ', $BusqDatosRango);

				$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
				$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

				// Asignar los parámetros de fecha
				$parametros[':fechainicio'] = $fechaInicio;
				$parametros[':fechafin'] = $fechaFin;
		}


		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA EL PROMEDIO DE HOSPEDAJE POR RANGO DE FECHA */
	function mostrarPromedioEstadia($BusqDatosRango){
		$sql = "SELECT COALESCE(FLOOR(AVG(DATEDIFF(fechafinal, fechainicio))), 0) AS promedioestadia
		FROM hospedaje
		WHERE fechafinal BETWEEN :fechainicio AND :fechafin
			AND fechafinal IS NOT NULL;
				";

		$sql="SELECT COALESCE(FLOOR(AVG(DATEDIFF(fechafinal, fechainicio))), 0) AS promedioestadia
		FROM hospedaje
		WHERE (
					(fechainicio BETWEEN :fechainicio AND :fechafin)
					OR (fechafinal BETWEEN :fechainicio AND :fechafin)
					OR (fechainicio < :fechainicio AND fechafinal > :fechafin)
					)
		AND fechafinal IS NOT NULL;
		";

		$parametros = array();

		if ($BusqDatosRango != "") {
				$fechas = explode(' - ', $BusqDatosRango);

				$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
				$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

				// Asignar los parámetros de fecha
				$parametros[':fechainicio'] = $fechaInicio;
				$parametros[':fechafin'] = $fechaFin;
		}


		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS HOSPEDAJES REALIZADOS POR RANGO DE FECHA */
	function mostrarHuespedesRegistrados($BusqDatosRango){
		$sql = "SELECT COUNT(*) as 'huespedesregistrados'
			FROM hospedar
			WHERE fechaingreso BETWEEN :fechainicio AND :fechafin";

		$parametros = array();

		if ($BusqDatosRango != "") {
				$fechas = explode(' - ', $BusqDatosRango);

				$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
				$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

				// Asignar los parámetros de fecha
				$parametros[':fechainicio'] = $fechaInicio;
				$parametros[':fechafin'] = $fechaFin;
		}


		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

		/* MUESTRA LOS HUESPEDES FRECUENTES POR RANGO FECHA */
		function mostrarHuespedesFrecuentes($BusqDatosRango){
			$sql = "SELECT 
			COUNT(*) AS 'huespedesfrecuentes'
			FROM 
					(SELECT 
							id_huesped
					FROM 
							hospedar
					WHERE 
							fechaingreso BETWEEN :fechainicio AND :fechafin
					GROUP BY 
							id_huesped
					HAVING 
							COUNT(id_huesped) > 1) AS subconsulta;";
	
			$parametros = array();
	
			if ($BusqDatosRango != "") {
					$fechas = explode(' - ', $BusqDatosRango);
	
					$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
					$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');
	
					// Asignar los parámetros de fecha
					$parametros[':fechainicio'] = $fechaInicio;
					$parametros[':fechafin'] = $fechaFin;
			}
	
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

		/* MUESTRA LOS INGRESOS Y EGRESOS POR RANGO DE FECHA */
		function listarDatosFlujo($BusqDatosRango){
			$sql = "SELECT CONCAT(MONTHNAME(tra.fecha), ' - ', YEAR(tra.fecha)) AS mes, 
               SUM(CASE WHEN tra.tipotransaccion = 'Ingreso' THEN tra.monto ELSE 0 END) AS total_ingresos,
               SUM(CASE WHEN tra.tipotransaccion = 'Egreso' THEN tra.monto ELSE 0 END) AS total_egresos
        FROM transaccion tra
        WHERE DATE(tra.fecha) BETWEEN :fechainicio AND :fechafin
        GROUP BY MONTH(tra.fecha)
        ORDER BY MONTH(tra.fecha) ASC";

			$parametros = array();

			if ($BusqDatosRango != "") {
					$fechas = explode(' - ', $BusqDatosRango);

					$fechaInicio = DateTime::createFromFormat('d/m/Y', $fechas[0])->format('Y-m-d');
					$fechaFin = DateTime::createFromFormat('d/m/Y', $fechas[1])->format('Y-m-d');

					// Asignar los parámetros de fecha
					$parametros[':fechainicio'] = $fechaInicio;
					$parametros[':fechafin'] = $fechaFin;
			}
	

			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

		function contarhabitacionesOcupadas(){
			$sql = "SELECT COUNT(*) as 'habitacionocupada' FROM habitacion WHERE estadohabitacion=1";
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute();
			return $pre;
		}

		function contarhabitacionesDisponibles(){
			$sql = "SELECT COUNT(*) as 'habitaciondisponible' FROM habitacion WHERE estadohabitacion=0";
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute();
			return $pre;
		}

		function contarhabitacionesLimpieza(){
			$sql = "SELECT COUNT(*) as 'habitacionlimpiando' FROM habitacion WHERE estadohabitacion=2";
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute();
			return $pre;
		}

		function contarhuespedesEncurso(){
			$sql = "SELECT COUNT(*) as 'huespedescurso' FROM hospedar WHERE fechasalida IS NULL";
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute();
			return $pre;
		}


}
?>