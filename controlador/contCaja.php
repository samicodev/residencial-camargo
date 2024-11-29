<?php
require_once('../modelo/clsCaja.php');

controlador($_POST['accion']);

function controlador($accion){
	$objCaja = new clsCaja();

	switch ($accion) {
			case 'NUEVO':
				$resultado = array();
				try {
	
					$saldoinicial = $_POST['saldoinicial'];
					$observacion = $_POST['observacion'];
	
					$existeCaja = $objCaja->verificarDuplicado();
					if($existeCaja->rowCount()>0){
						throw new Exception("Ya existe una caja aperturada", 1);
					}
						
					$objCaja->insertarCaja($saldoinicial,$observacion);
					$resultado['correcto']=1;
					$resultado['mensaje'] = 'Datos de la caja registrados de forma satisfactoria.';
	
					echo json_encode($resultado);
					
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje'] = $e->getMessage();
					echo json_encode($resultado);
				}
				break;

		case 'CONSULTAR_CAJA':
			try {
				$idcaja = $_POST['idcaja'];

				$resultado = $objCaja->consultarCaja($idcaja);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		case 'ACTUALIZAR':
			$resultado = array();
			try {
				$idcaja = $_POST['idcaja'];

				$saldoinicial = $_POST['saldoinicial'];
				$observacion = $_POST['observacion'];

				/* $existeCaja = $objCaja->verificarDuplicado($saldoinicial, $observacion,$idcaja);
				if($existeCaja->rowCount()>0){
					throw new Exception("El documento ya esta registrado en la base de datos", 1);
				} */

				$objCaja->actualizarCaja($idcaja, $saldoinicial,$observacion);

				$resultado['correcto']=1;
				$resultado['mensaje']="Datos de la caja actualizados de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_CAJA':
			$resultado = array();
			try {
				$idcaja = $_POST['idcaja'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objCaja->actualizarEstadoCaja($idcaja, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='El registro de la caja ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;


			/* MOSTRAR LAS TRANSACCIONES DE LA CAJA */
			case 'CONSULTAR_TRANSACCIONES':
			try {
				$idcaja = $_POST['idcaja'];

				$resultado = $objCaja->listarTransacciones($idcaja);
				$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
				echo json_encode($resultado);

			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

			case 'VER_TRANSACCIONES':
				try {
					$idcaja = $_POST['idcaja'];
					$fechainicio = $_POST['fechainicio'];
					$fechafin = $_POST['fechafin'];
	
					$resultado = $objCaja->verTransacciones($idcaja,$fechainicio,$fechafin);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
				break;

			/* CERRAR CAJA */
			case 'CERRAR_CAJA':
				$resultado = array();
				try {
	
					$idcaja = $_POST['idcaja'];
	
					$objCaja->cerrarCaja($idcaja);
	
					$resultado['correcto']=1;
					$resultado['mensaje']="La caja se ha cerrado de forma satisfactoria.";
					echo json_encode($resultado);
	
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje']=$e->getMessage();
	
					echo json_encode($resultado);
				}
			break;

			case 'NUEVO_EGRESO':
				$resultado = array();
				try {
	
					$metodo_pago = $_POST['metodo_pago'];
					$monto_pago = $_POST['monto_pago'];
					$detalle = $_POST['detalle'];
					$idusuario = $_SESSION['idusuario'];
					$idcaja = $_POST['idcaja_egreso'];

						
					$objCaja->insertarEgreso($metodo_pago,$monto_pago,$detalle,$idusuario,$idcaja);
					$resultado['correcto']=1;
					$resultado['mensaje'] = 'Datos del egreso registrados de forma satisfactoria.';
	
					echo json_encode($resultado);
					
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje'] = $e->getMessage();
					echo json_encode($resultado);
				}
				break;

			default:
			echo "No ha definido una accion";
			break;
	}

}

?>