<?php
require_once('conexion.php');

class clsHuesped{

	function listarHuesped($nroDoc, $tipoDoc, $BsqFeNac,$BsqFeNomb,$BsqFeNacion, $estado){
		$sql = "SELECT hue.*, DATE_FORMAT(hue.fenac, '%d/%m/%Y') AS fechanac, tipdoc.nombre as 'tipdoc' FROM huesped hue 
		INNER JOIN tipodocumento tipdoc ON hue.id_tipodocumento=tipdoc.id_tipodocumento
		WHERE hue.estado<2 AND tipdoc.estado<2";
		$parametros = array();

		if($BsqFeNomb!=""){
			$sql .= " AND hue.nombcomp LIKE :BsqFeNomb ";
			$parametros[':BsqFeNomb'] = "%".$BsqFeNomb."%";
		}

		if($BsqFeNacion!=""){
			$sql .= " AND hue.nacionalidad LIKE :BsqFeNacion ";
			$parametros[':BsqFeNacion'] = "%".$BsqFeNacion."%";
		}

		if($nroDoc!=""){
			$sql .= " AND hue.nrodocumento LIKE :nrodoc ";
			$parametros[':nrodoc'] = "%".$nroDoc."%";
		}

		if($tipoDoc!=""){
			$sql .= " AND hue.id_tipodocumento LIKE :tipodoc ";
			$parametros[':tipodoc'] = "%".$tipoDoc."%";
		}

		if($BsqFeNac!=""){
			$sql .= " AND hue.fenac = :BsqFeNac ";
			$parametros[':BsqFeNac'] = $BsqFeNac;
		}

		if($estado!=""){
			$sql .= " AND hue.estado = :estado ";
			$parametros[':estado'] = $estado;
		}

		$sql .= " ORDER BY hue.id_huesped DESC";

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

	function insertarHuesped($nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc) {
    $sql = "INSERT INTO huesped (nombcomp, nrodocumento, id_tipodocumento, fenac, nacionalidad, profesion)
                   VALUES (:nombcomp, :nrodocumento, :id_tipodocumento, :fenac, :nacionalidad, :profesion)";
    
    $parametros = array(
			":nombcomp" => $nomhuesped,
			":nrodocumento" => $nrodoc,
			":id_tipodocumento" => $tipodoc,
        ":fenac" => $fenac,
        ":nacionalidad" => $nacionalidad,
        ":profesion" => $profesion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
}


	function verificarDuplicado($nrodoc, $tipodoc, $idhuesped){
		$sql = "SELECT * FROM huesped WHERE estado<2 AND nrodocumento=:nrodoc AND id_tipodocumento=:idtipodoc AND id_huesped<>:idhuesped";
		$parametros = array(":nrodoc"=>$nrodoc, ":idtipodoc"=>$tipodoc,":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function consultarHuesped($idhuesped){
		$sql = "SELECT * FROM huesped WHERE id_huesped=:idhuesped ";
		$parametros = array(":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarHuesped($idhuesped, $nomhuesped,$nacionalidad,$nrodoc,$profesion,$fenac,$tipodoc){
		$sql = "UPDATE huesped SET nombcomp=:nombre, nrodocumento	=:nrodoc, id_tipodocumento=:idtipdoc, fenac=:fenac, nacionalidad=:nacionalidad, profesion=:prof WHERE id_huesped=:idhuesped";
		$parametros = array(
			":idhuesped"=>$idhuesped, 
			":nombre"=>$nomhuesped, 
			":nrodoc"=>$nrodoc, 
			":idtipdoc"=>$tipodoc, 
			":fenac"=>$fenac, 
			":nacionalidad"=>$nacionalidad, 
			":prof"=>$profesion
		);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

	function actualizarEstadoHuesped($idhuesped, $estado){
		$sql = "UPDATE huesped SET estado=:estado WHERE id_huesped=:idhuesped";
		$parametros = array(":estado"=>$estado, ":idhuesped"=>$idhuesped);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}

}
?>