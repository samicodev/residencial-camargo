<?php
require_once('conexion.php');

class clsHospedaje
{

	function listarHabitacion($habitacion, $idtipohabitacion, $estado)
	{
		$sql = "SELECT hab.*, tipohab.nombre as 'nombre_tipohabitacion' FROM habitacion hab INNER JOIN tipohabitacion tipohab ON hab.id_tipohabitacion=tipohab.id_tipohabitacion WHERE hab.estado<4 AND tipohab.estado<3";
		$parametros = array();

		if ($habitacion != "") {
			$sql .= " AND hab.codigohabitacion LIKE :codigohabitacion ";
			$parametros[':codigohabitacion'] = "%" . $habitacion . "%";
		}

		if ($idtipohabitacion != "") {
			$sql .= " AND hab.id_tipohabitacion = :id_tipohabitacion ";
			$parametros[':id_tipohabitacion'] = $idtipohabitacion;
		}

		if ($estado != "") {
			$sql .= " AND hab.estadohabitacion = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hab.codigohabitacion DESC";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	/* OBSERVACION */
	function insertarHospedaje($idhabitacion, $cantnoche, $obs)
	{
		// Insertar en la tabla hospedaje
		$sqlInsert = "INSERT INTO hospedaje(id_habitacion, totalnoches, fechainicio, observacion) VALUES(:idhabitacion, :cantnoches, NOW(), :obs)";
		$parametrosInsert = array(
			":idhabitacion" => $idhabitacion,
			":cantnoches" => $cantnoche,
			":obs" => $obs
		);

		global $cnx;
		$preInsert = $cnx->prepare($sqlInsert);
		$preInsert->execute($parametrosInsert);

		// Realizar un UPDATE en otra tabla después del INSERT
		$sqlUpdate = "UPDATE habitacion SET estado = 3 WHERE id_habitacion = :idhabitacion";
		$parametrosUpdate = array(
			":idhabitacion" => $idhabitacion
			// Aquí puedes añadir más parámetros necesarios para el UPDATE
		);

		$preUpdate = $cnx->prepare($sqlUpdate);
		$preUpdate->execute($parametrosUpdate);

		return $preInsert; // Devuelve el resultado del INSERT
	}


	function listarHospedaje()
	{
		$sql = "SELECT * FROM hospedaje WHERE fechafinal IS NULL";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function iniciarHospedaje($idhabitacion, $fechaActual)
	{
		$sql = "INSERT INTO hospedaje(id_habitacion,fechainicio) VALUES(:idhabitacion,:fechaactual)";
		$parametros = array(
			":idhabitacion" => $idhabitacion,
			":fechaactual" => $fechaActual
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function finalizarHospedaje($idhospedaje, $fechaActual)
	{
		$sql = "UPDATE hospedaje SET fechafinal=:fechaactual WHERE id_hospedaje=:idhospedaje";
		$parametros = array(
			":idhospedaje" => $idhospedaje,
			":fechaactual" => $fechaActual
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* SE AGREGA HUESPED EN LA HABITACION */
	function insertarHospedar($idhospedaje, $idhuesped, $resante, $motviaje, $fechaActual)
	{
		$sql = "INSERT INTO hospedar(id_hospedaje,id_huesped,resante,motviaje,fechaingreso) VALUES(:id_hospedaje, :id_huesped, :resante, :motviaje, :fechaactual)";
		$parametros = array(
			":id_hospedaje" => $idhospedaje,
			":id_huesped" => $idhuesped,
			":resante" => $resante,
			":motviaje" => $motviaje,
			":fechaactual" => $fechaActual
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function finalizarEstadiaHuesped($idhospedar, $fechaActual)
	{
		$sql = "UPDATE hospedar SET fechasalida=:fechaactual WHERE id_hospedar=:idhospedar";
		$parametros = array(
			":idhospedar" => $idhospedar,
			":fechaactual" => $fechaActual
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function listarNumeroHospedaje()
	{
		$sql = "SELECT DISTINCT hospe.id_hospedaje, hospe.id_habitacion, hospe.fechafinal FROM hospedar hos
		INNER JOIN hospedaje hospe
		ON hos.id_hospedaje=hospe.id_hospedaje WHERE hospe.fechafinal IS NULL";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS DATOS DEL HOSPEDAJE*/
	function consultarDatosHospedaje($idhospedaje)
	{
		$sql = "SELECT 
    hos.id_hospedaje,hos.id_habitacion,
   	DATE_FORMAT(hos.fechainicio, '%d/%m/%Y  %H:%i%p') AS fechainicio,
    hab.codigohabitacion AS numerohabitacion,
    tipohab.nombre AS tipohabitacion,
    hos.fechainicio AS fechainiciohospedaje,
    tipohab.precio AS preciohabitacion,
    hos.observacion AS observacionhospedaje,
    hos.duracionestadia AS diashospedaje,
    (hos.duracionestadia * tipohab.precio) AS costototal,
		IFNULL(SUM(CASE WHEN tr.tipotransaccion = 'Ingreso' THEN tr.monto ELSE 0 END), 0) AS totalpagado,
		((hos.duracionestadia * tipohab.precio) - IFNULL(SUM(CASE WHEN tr.tipotransaccion = 'Ingreso' THEN tr.monto ELSE 0 END), 0)) AS saldopendiente
		FROM hospedaje hos
		JOIN habitacion hab 
		ON hos.id_habitacion = hab.id_habitacion
		JOIN tipohabitacion tipohab 
		ON hab.id_tipohabitacion = tipohab.id_tipohabitacion
		LEFT JOIN transaccion tr
    ON hos.id_hospedaje = tr.idhospedaje
		WHERE hos.id_hospedaje = :idhospedaje
		GROUP BY 
    hos.id_hospedaje,
    hab.codigohabitacion,
    tipohab.nombre,
    hos.fechainicio,
    tipohab.precio,
    hos.observacion,
    hos.duracionestadia";
		$parametros = array(":idhospedaje" => $idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS HUESPEDES QUE ESTAN EN LA HABITACION */
	function listarHuespedes($idhospedaje)
	{
		$sql = "SELECT hospe.id_hospedaje, hos.id_hospedar, hos.resante, hue.nombcomp, hue.nrodocumento, TIMESTAMPDIFF(YEAR, hue.fenac, CURDATE()) as edad, hue.nacionalidad, hue.id_huesped
		FROM hospedaje hospe
		INNER JOIN hospedar hos
		ON hospe.id_hospedaje=hos.id_hospedaje
		INNER JOIN huesped hue
		ON hos.id_huesped=hue.id_huesped
		WHERE hos.id_hospedaje=:idhospedaje AND hos.fechasalida IS NULL";


		$parametros = array(":idhospedaje" => $idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function verificarDuplicado($codigo, $id_habitacion = 0)
	{
		$sql = "SELECT * FROM habitacion WHERE estado<2 AND codigohabitacion=:codigo AND id_habitacion<>:id_habitacion";
		$parametros = array(":codigo" => $codigo, ":id_habitacion" => $id_habitacion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* BUSCA SI EL HUESPED EXISTE EN LA BASE DE DATOS */
	function consultarHuesped($idhue)
	{
		$sql = "SELECT nombcomp as 'nombre', huesped.id_huesped as 'id_hue' FROM huesped WHERE nrodocumento=:idhue";
		$parametros = array(":idhue" => $idhue);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function consultarTipoMetodoPago()
	{
		$sql = "SELECT * FROM metodopago";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function registrarPago($idhospedaje, $idhuesped, $metodopago, $montopago, $descripcionpago, $idCajaAbierta, $idusuario)
	{
		$sql = "INSERT INTO transaccion(monto,descripcion,tipotransaccion,idmetodopago,idhuesped,idcaja,idhospedaje,idusuario,fecha) VALUES(:montopago,:descripcionpago,'Ingreso',:metodopago,:idhuesped,:idcaja,:idhospedaje,:idusuario,NOW())";
		$parametros = array(
			":montopago" => $montopago,
			":descripcionpago" => $descripcionpago,
			":metodopago" => $metodopago,
			":idhuesped" => $idhuesped,
			":idcaja" => $idCajaAbierta,
			":idusuario" => $idusuario,
			":idhospedaje" => $idhospedaje
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* REVISA SI HAY UNA CAJA SIN FECHA DE CIERRE */
	function verificarCajaAbierta()
	{
		$sql = "SELECT idcaja FROM caja WHERE fechacierre IS NULL AND estado < 2";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute();

		return $pre;
	}

	/* VERIFICA SI HAY UN HUESPEDE QUE YA ESTE ALOJADO */
	public function verificarHuespedHospedado($idhuesped)
	{
		$sql = "SELECT * FROM hospedar WHERE id_huesped = :idhuesped AND fechasalida IS NULL";

		$parametros = array(":idhuesped" => $idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarTiempoEstadia($idhospedaje, $duracionestadia, $observacion)
	{
		$sql = "UPDATE hospedaje SET duracionestadia=:duracionestadia, observacion=:observacion WHERE id_hospedaje=:id_hospedaje";
		$parametros = array(
			":duracionestadia" => $duracionestadia,
			":observacion" => $observacion,
			":id_hospedaje" => $idhospedaje
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* MUESTRA LOS PAGOS POR EL HOSPEDAJE */
	function mostrarPagosHospedaje($idhospedaje)
	{
		$sql = "SELECT tr.idtransaccion, tr.monto,DATE_FORMAT(tr.fecha, '%d/%m/%Y  %h:%i %p') as 'fecha',hue.nombcomp,hue.id_huesped,hue.nrodocumento,usu.nombre as 'responsable',mep.nombre as 'metodopago', hab.codigohabitacion
		FROM transaccion tr
		INNER JOIN hospedaje hos
    ON hos.id_hospedaje=tr.idhospedaje
		INNER JOIN habitacion hab
    ON hab.id_habitacion=hos.id_habitacion
		INNER JOIN huesped hue
		ON tr.idhuesped=hue.id_huesped
		INNER JOIN usuario usu
		ON tr.idusuario=usu.idusuario
		INNER JOIN metodopago mep
		ON tr.idmetodopago=mep.idmetodopago
		WHERE tr.idhospedaje=:idhospedaje ORDER BY tr.fecha DESC";


		$parametros = array(":idhospedaje" => $idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	/* ACTUALIZAR ESTADO DE HABITACION A OCUPADA */
	function actualizarEstadoHabitacion($idhabitacion,$estadohabitacion){
		$sql = "UPDATE habitacion SET estadohabitacion=:estadohabitacion WHERE id_habitacion=:idhabitacion";
		$parametros = array(
			":idhabitacion"=>$idhabitacion, 
			":estadohabitacion"=>$estadohabitacion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	/* REVISAR SI EXISTEN HUESPEDES EN LA HABITACION */
	function verificarHuespedesExistentes($idhospedaje)
	{
		$sql = "SELECT *
		FROM hospedar hos
		WHERE hos.id_hospedaje=:idhospedaje AND hos.fechasalida IS NULL";


		$parametros = array(":idhospedaje" => $idhospedaje);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}
}
