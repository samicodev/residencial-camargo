<?php
require_once('../modelo/clsResumen.php');

controlador($_POST['accion']);

function controlador($accion){
	$objRes = new clsResumen();

	switch ($accion) {
		case 'NUEVO':
			$resultado = array();
			try {

				$codigo = $_POST['codigo'];
				$idTipoHabitacion = $_POST['idTipoHabitacion'];
				$estado = $_POST['estado'];

				$existeHabitacion = $objRes->verificarDuplicado($codigo);
				if($existeHabitacion->rowCount()>0){
					throw new Exception("Ya Existe una habitacion registrada con el mismo número", 1);
				}
					
				$objRes->insertarHabitacion($codigo,$idTipoHabitacion,$estado);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Habitacion Registrada de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
			break;

		case 'CONSULTAR_HABITACION':
			try {
				$idhabitacion = $_POST['idhabitacion'];

				$resultado = $objRes->consultarHabitacion($idhabitacion);
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
				$idhabitacion = $_POST['idhabitacion'];
				$codigo = $_POST['codigo'];
				$idTipoHabitacion = $_POST['idTipoHabitacion'];
				$estado = $_POST['estado'];

				$existeHabitacion= $objRes->verificarDuplicado($codigo, $idhabitacion);
				if($existeHabitacion->rowCount()>0){
					throw new Exception("Ya Existe una Habitacion Registrada con el mismo codigo", 1);
					
				}

				$objRes->actualizarHabitacion($idhabitacion, $codigo,$idTipoHabitacion,$estado);

				$resultado['correcto']=1;
				$resultado['mensaje']="Habitacion actualizada de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

		case 'CAMBIAR_ESTADO_HABITACION':
			$resultado = array();
			try {
				$idhabitacion = $_POST['idhabitacion'];
				$estado = $_POST['estado'];
				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');

				$objRes->actualizarEstadoHabitacion($idhabitacion, $estado);

				$resultado['correcto']=1;
				$resultado['mensaje']='La Habitacion ha sido '.$arrayEstado[$estado].' de forma satisfactoria';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
			break;

			/* MOSTRAR LOS NUEVOS HUESPEDES */
			case 'HUESPEDES_NUEVOS':
				try {
					$BusqDatosRango = $_POST['BusqDatosRango'];
	
					$resultado = $objRes->mostrarHuespedesNuevos($BusqDatosRango);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
			break;

			/* MOSTRAR LOS HOSPEDAJES REALIZADOS */
			case 'HOSPEDAJES_REALIZADOS':
				try {
					$BusqDatosRango = $_POST['BusqDatosRango'];
	
					$resultado = $objRes->mostrarHospedajesRealizados($BusqDatosRango);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
			break;

			/* MOSTRAR PROMEDIO DE ESTADIA */
			case 'PROMEDIO_ESTADIA':
				try {
					$BusqDatosRango = $_POST['BusqDatosRango'];
	
					$resultado = $objRes->mostrarPromedioEstadia($BusqDatosRango);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
			break;

			/* MOSTRAR LOS HOSPEDAJES REALIZADOS */
			case 'HUESPEDES_FRECUENTES':
				try {
					$BusqDatosRango = $_POST['BusqDatosRango'];
	
					$resultado = $objRes->mostrarHuespedesFrecuentes($BusqDatosRango);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
			break;

			/* MOSTRAR LOS HOSPEDAJES REALIZADOS */
			case 'HUESPEDES_REGISTRADOS':
				try {
					$BusqDatosRango = $_POST['BusqDatosRango'];
	
					$resultado = $objRes->mostrarHuespedesRegistrados($BusqDatosRango);
					$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
					echo json_encode($resultado);
	
				
				} catch (Exception $e) {
					$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
					echo json_encode($resultado);
				}
			break;


    		/* MOSTRAR LOS INGRESOS Y EGRESOS POR FECHA */
		case 'LISTAR_FLUJO_CAJA':
			try {
				$BusqDatosRango = $_POST['BusqDatosRango'];

				$resultado = $objRes->listarDatosFlujo($BusqDatosRango);
				$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
				echo json_encode($resultado);

			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
		break;
		
		default:
			echo "No ha definido una accion";
			break;
	}

}

?>