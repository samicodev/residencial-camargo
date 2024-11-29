<?php
require_once('conexion.php');

class clsCaja{

	function listarCaja($fechaapertura, $fechacierre, $estado){

		$sql= " SELECT
    caj.idcaja,
    caj.saldoinicial,
    DATE_FORMAT(caj.fechaapertura,'%d/%m/%Y  %h:%i %p') as 'fechaapertura',
    DATE_FORMAT(caj.fechacierre,'%d/%m/%Y  %h:%i %p') as 'fechacierre',
    caj.observacion,
    caj.estado,
    SUM(CASE 
        WHEN tra.tipotransaccion = 'Ingreso' THEN tra.monto 
        WHEN tra.tipotransaccion = 'Egreso' THEN -tra.monto 
        ELSE 0 
    END) AS totaltransacciones,
    (caj.saldoinicial + SUM(CASE 
        WHEN tra.tipotransaccion = 'Ingreso' THEN tra.monto 
        WHEN tra.tipotransaccion = 'Egreso' THEN -tra.monto 
        ELSE 0 
    END)) AS saldofinal
		FROM
				caja caj
		LEFT JOIN
				transaccion tra ON caj.idcaja = tra.idcaja
		WHERE
    caj.estado < 2";

		$parametros = array();

		if ($fechaapertura != "") {
			// Usar la fecha convertida en la consulta
			$sql .= " AND DATE(caj.fechaapertura) = :fechaapertura ";
			$parametros[':fechaapertura'] = $fechaapertura;
		}

		if ($fechacierre != "") {
			$sql .= " AND DATE(caj.fechacierre) = :fechacierre ";
			$parametros[':fechacierre'] = $fechacierre;
		}

		if($estado!=""){
			$sql .= " AND caj.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " GROUP BY
    caj.idcaja, caj.saldoinicial, caj.fechaapertura, caj.fechacierre, caj.observacion";

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function consultarTipoDocumento(){
		$sql = "SELECT * FROM tipodocumento";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function insertarCaja($saldoinicial,$observacion) {
    $sql = "INSERT INTO caja (fechaapertura, saldoinicial, observacion)
                   VALUES (NOW(), :saldoinicial, :observacion)";
    
    $parametros = array(
			":saldoinicial" => $saldoinicial,
			":observacion" => $observacion

		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
}


	function verificarDuplicado(){
		$sql = "SELECT * FROM caja WHERE estado<2 AND fechacierre IS NULL";
		$parametros = array();

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarCaja($idcaja){
		$sql = "SELECT * FROM caja WHERE idcaja=:idcaja ";
		$parametros = array(":idcaja"=>$idcaja);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarCaja($idcaja, $saldoinicial,$observacion){
		$sql = "UPDATE caja SET saldoinicial=:saldoinicial, observacion=:observacion WHERE idcaja=:idcaja";
		$parametros = array(
			":idcaja"=>$idcaja, 
			":saldoinicial"=>$saldoinicial, 
			":observacion"=>$observacion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoCaja($idcaja, $estado){
		$sql = "UPDATE caja SET estado=:estado WHERE idcaja=:idcaja";
		$parametros = array(":estado"=>$estado, ":idcaja"=>$idcaja);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

		/* MUESTRA LAS TRANSACCIONES QUE ESTAN EN LA CAJA */
		function listarTransacciones($idcaja){
			$sql = "SELECT caj.*, tra.*,mpa.nombre as 'metodopago',hue.nombcomp, DATE_FORMAT(tra.fecha, '%d/%m/%Y  %h:%i %p') as 'fechapago', usu.nombre as 'responsable', DATE_FORMAT(caj.fechaapertura, '%d/%m/%Y %h:%i %p') as 'fechaaperturacaja', caj.observacion as 'observacioncaja', DATE_FORMAT(caj.fechacierre, '%d/%m/%Y %h:%i %p') as 'fechacierrecaja'
			FROM caja caj
			LEFT JOIN transaccion tra
			ON caj.idcaja=tra.idcaja
			LEFT JOIN usuario usu
			ON tra.idusuario=usu.idusuario
			LEFT JOIN metodopago mpa
			ON tra.idmetodopago=mpa.idmetodopago
			LEFT JOIN huesped hue
			ON tra.idhuesped=hue.id_huesped
			WHERE caj.idcaja=:idcaja ORDER BY tra.fecha ASC";
	
	
			$parametros = array(":idcaja"=>$idcaja);
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

		function verTransacciones($idcaja,$fechainicio,$fechafin){
			$sql = "SELECT caj.*, tra.*,mpa.nombre as 'metodopago',hue.nombcomp, DATE_FORMAT(tra.fecha, '%d/%m/%Y  %h:%i %p') as 'fechapago', usu.nombre as 'responsable', DATE_FORMAT(caj.fechaapertura, '%d/%m/%Y %h:%i %p') as 'fechaaperturacaja', caj.observacion as 'observacioncaja', DATE_FORMAT(caj.fechacierre, '%d/%m/%Y %h:%i %p') as 'fechacierrecaja'
			FROM caja caj
			LEFT JOIN transaccion tra
			ON caj.idcaja=tra.idcaja
			LEFT JOIN usuario usu
			ON tra.idusuario=usu.idusuario
			LEFT JOIN metodopago mpa
			ON tra.idmetodopago=mpa.idmetodopago
			LEFT JOIN huesped hue
			ON tra.idhuesped=hue.id_huesped
			WHERE caj.idcaja=:idcaja ";
	
			$parametros = array(":idcaja"=>$idcaja);

			if($fechainicio!="" && $fechafin !=""){
				$sql .= " AND DATE(tra.fecha) BETWEEN :fechainicio AND :fechafin";
				$parametros[':fechainicio'] = $fechainicio;
				$parametros[':fechafin'] = $fechafin;
			}

			$sql .= " ORDER BY tra.fecha ASC";
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

		/* CERRAR CAJA */
		function cerrarCaja($idcaja){
			$sql = "UPDATE caja SET fechacierre=NOW() WHERE idcaja=:idcaja";
			$parametros = array(
				":idcaja"=>$idcaja
			);
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
		}

		/* GUARDAD EGRESO */
		function insertarEgreso($metodo_pago,$monto_pago,$detalle,$idusuario,$idcaja){
			$sql = "INSERT INTO transaccion (monto, descripcion, tipotransaccion, idmetodopago, idhuesped,idhospedaje, idcaja,idusuario,fecha)
										 VALUES (:monto, :descripcion, 'Egreso', :idmetodopago, 0, 0,:idcaja,:idusuario,NOW())";
			
			$parametros = array(
				":monto" => $monto_pago,
				":descripcion" => $detalle,
					":idmetodopago" => $metodo_pago,
					":idcaja" => $idcaja,
					":idusuario" => $idusuario
			);
	
			global $cnx;
			$pre = $cnx->prepare($sql);
			$pre->execute($parametros);
			return $pre;
	}

}
?>