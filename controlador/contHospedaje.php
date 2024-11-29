<?php
require_once('../modelo/clsHospedaje.php');

date_default_timezone_set('America/La_Paz');
$fechaActual=date('Y-m-d H:i:s');

controlador($_POST['accion'], $fechaActual);

function controlador($accion, $fechaActual){
	$objHos = new clsHospedaje();

	switch ($accion) {

		case 'INICIAR_HOSPEDAJE':
			$resultado = array();
			try {

				$idhabitacion = $_POST['idhabitacion'];
				$estadohabitacion=1;


				$existeCajaAbierta = $objHos->verificarCajaAbierta();
					if ($existeCajaAbierta->rowCount() > 0) {
						$objHos->iniciarHospedaje($idhabitacion,$fechaActual);

						$objHos->actualizarEstadoHabitacion($idhabitacion,$estadohabitacion);
		
						$resultado['correcto']=1;
						$resultado['mensaje']="Hospedaje iniciado de forma satisfactoria.";
						echo json_encode($resultado);

					} else {
							throw new Exception("No existe una caja aperturada", 1);
					}


				/* $objHos->iniciarHospedaje($idhabitacion,$fechaActual);

				$objHos->actualizarEstadoHabitacion($idhabitacion,$estadohabitacion);

				$resultado['correcto']=1;
				$resultado['mensaje']="Hospedaje iniciado de forma satisfactoria.";
				echo json_encode($resultado); */

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
		break;

		case 'FINALIZAR_HOSPEDAJE':
			$resultado = array();
			try {

				$idhospedaje = $_POST['idhospedaje'];
				$idhabitacion = $_POST['idhabitacion'];
				$estadohabitacion=2;


				$objHos->finalizarHospedaje($idhospedaje,$fechaActual);
				$objHos->actualizarEstadoHabitacion($idhabitacion,$estadohabitacion);

				$resultado['correcto']=1;
				$resultado['mensaje']="Hospedaje finalizado de forma satisfactoria.";
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
				$estadohabitacion=0;

				$objHos->actualizarEstadoHabitacion($idhabitacion,$estadohabitacion);

				$resultado['correcto']=1;
				$resultado['mensaje']="Habitacion actualizada de forma satisfactoria";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
		break;

		/* AGREGAR HUESPED A LA HABITACION */
		case 'NUEVO_HOSPEDAR':
			$resultado = array();
			try {
				$idhospedaje = $_POST['idhospedar'];
				$idhuesped = $_POST['idhuesped'];
				$resante = $_POST['resante'];
				$motviaje = $_POST['motviaje'];

				$existeHuesped = $objHos->verificarHuespedHospedado($idhuesped);
				if($existeHuesped->rowCount()>0){
					throw new Exception("El huesped ya esta registrado en una habitacion", 1);
					
				}
					
				$objHos->insertarHospedar($idhospedaje,$idhuesped,$resante,$motviaje,$fechaActual);
				$resultado['correcto']=1;
				$resultado['mensaje'] = 'Huesped agregado de forma satisfactoria.';

				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje'] = $e->getMessage();
				echo json_encode($resultado);
			}
		break;

		case 'FINALIZAR_ESTADIA_HUESPED':
			$resultado = array();
			try {

				$idhospedar = $_POST['idhospedar'];
				$idhospedaje = $_POST['idhospedaje'];



				/* $listarHuespedes= $objHos->listarHuespedes($idhospedaje);
					if ($listarHuespedes->rowCount() > 1) {
						$objHos->finalizarEstadiaHuesped($idhospedar,$fechaActual);

						$resultado['correcto']=1;
						$resultado['mensaje']="Se registro la salida del huesped de forma satisfactoria.";
						echo json_encode($resultado);

					} else {
							throw new Exception("Existe un saldo pendiente por pagar", 1);
					} */



				$objHos->finalizarEstadiaHuesped($idhospedar,$fechaActual);

				$resultado['correcto']=1;
				$resultado['mensaje']="Se registro la salida del huesped de forma satisfactoria.";
				echo json_encode($resultado);

			} catch (Exception $e) {
				$resultado['correcto']=0;
				$resultado['mensaje']=$e->getMessage();

				echo json_encode($resultado);
			}
		break;

		/* MOSTRAR DATOS DEL HOSPEDAJE */
		case 'CONSULTAR_DATOS_HOSPEDAJE':
			try {
				$idhospedaje = $_POST['idhospedaje'];

				$resultado = $objHos->consultarDatosHospedaje($idhospedaje);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		/* MOSTRAR LOS HUESPEDES DE LA HABITACION */
		case 'CONSULTAR_HUESPEDES':
			try {
				$idhospedaje = $_POST['idhospedaje'];
				

				$resultado = $objHos->listarHuespedes($idhospedaje);
				$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
				echo json_encode($resultado);

			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

		/* BUSQUEDA DE HUESPED */
		case 'CONSULTAR_HUESPED':
			try {
				$idhue = $_POST['idhue'];

				$resultado = $objHos->consultarHuesped($idhue);
				$resultado = $resultado->fetch(PDO::FETCH_NAMED);
				echo json_encode($resultado);
				
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

			/* REGISTRO DE PAGO */
			case 'NUEVO_PAGO':
				$resultado = array();
				try {
	
					$idhospedaje = $_POST['idhospedaje_pago'];
					/* $idhospedar = $_POST['idhospedar_pago']; */
					$idhuesped = $_POST['idhuesped_pago'];
					$metodopago = $_POST['metodo_pago'];
					$montopago = $_POST['monto_pago'];
					$descripcionpago = $_POST['descripcion_pago'];
					$idusuario = $_SESSION['idusuario'];


					$existeCajaAbierta = $objHos->verificarCajaAbierta();
					if ($existeCajaAbierta->rowCount() > 0) {
							$cajaAbierta = $existeCajaAbierta->fetch(PDO::FETCH_ASSOC);
							$idCajaAbierta = $cajaAbierta['idcaja'];

							$objHos->registrarPago($idhospedaje,$idhuesped,$metodopago,$montopago,$descripcionpago,$idCajaAbierta,$idusuario);
	
							$resultado['correcto']=1;
							$resultado['mensaje']="Pago registrado de forma satisfactoria.";
							echo json_encode($resultado);

					} else {
							throw new Exception("No existe una caja aperturada", 1);
					}
	
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje']=$e->getMessage();
	
					echo json_encode($resultado);
				}
			break;

			/* ACTUALIZAR TIEMPO DE ESTADIA */
			case 'ACTUALIZAR_ESTADIA':
				$resultado = array();
				try {
	
					$idhospedaje = $_POST['idhospedaje'];
					$duracionestadia = $_POST['duracionestadia'];
					$observacion = $_POST['observacion'];

					$objHos->actualizarTiempoEstadia($idhospedaje,$duracionestadia,$observacion);

					$resultado['correcto']=1;
					$resultado['mensaje']="Tiempo de estadia actualizado de forma satisfactoria.";
					echo json_encode($resultado);

	
				} catch (Exception $e) {
					$resultado['correcto']=0;
					$resultado['mensaje']=$e->getMessage();
	
					echo json_encode($resultado);
				}
			break;

			/* MOSTRAR LOS PAGOS POR EL HOSPEDAJE */
			case 'MOSTRAR_PAGOS':
			try {
				$idhospedaje = $_POST['idhospedaje'];

				$resultado = $objHos->mostrarPagosHospedaje($idhospedaje);
				$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);
				echo json_encode($resultado);

			
			} catch (Exception $e) {
				$resultado = array('correcto'=>0, 'mensaje'=>$e->getMessage());
				echo json_encode($resultado);
			}
			break;

			/* MOSTRAR SI EXISTEN HUESPEDES en LA HABITACION */
		case 'VERIFICAR_HUESPEDES_EXISTEN':
			try {
				$idhospedaje = $_POST['idhospedaje'];

				$resultado = $objHos->verificarHuespedesExistentes($idhospedaje);
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