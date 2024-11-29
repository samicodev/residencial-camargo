<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->Image('camargo-logo.png', 20, 5, 25); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Times', 'BU', 14); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(78); // Movernos a la derecha
      $this->SetTextColor(11, 12, 19); //color
      //creamos una celda o fila
      $this->Cell(40, 15, utf8_decode('RESIDENCIAL CAMARGO'), 0, 0, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(10); // Salto de línea
      $this->SetTextColor(50); //color

      /* DIRECCION */
      $this->Cell(120);  // mover a la derecha
      $this->SetFont('Times', '', 10);
      $this->Cell(96, 10, utf8_decode("Dirección: Final C./Comercio-Ayacucho"), 0, 0, '', 0);
      $this->Ln(5);

      /* FECHA */
      date_default_timezone_set('America/La_Paz');
      $hoy = date('d/m/Y');
      $this->Cell(10);  // mover a la derecha
      $this->SetFont('Times', '', 10);
      $this->Cell(96, 10, utf8_decode("Fecha: $hoy"), 0, 0, '', 0);
      $this->Ln(1);
      
      /* CONTACTO */
      $this->Cell(120);  // mover a la derecha
      $this->SetFont('Times', '', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono: 74774333"), 0, 0, '', 0);
      $this->Ln(10);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)
   }
}



$pdf = new PDF();
$pdf->AddPage("portrait"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFont('Times', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

require_once('../modelo/conexion.php'); //llamamos a la conexion BD

   date_default_timezone_set('America/La_Paz');
   $fechaActual = date('Y-m-d H:i:s');

   if (isset($_GET['id'])) {
      $idcaja = $_GET['id'];
   } else {
      header('Location: ../index.php');
   }



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
   $resultado = $pre;
	$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);

   /* TITULO DE LA TABLA */
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(211, 211, 211); // Color de fondo
$pdf->SetDrawColor(96, 95, 95); // Color del borde
$pdf->SetFont('Times', 'B', 12);
$pdf->Cell(190, 7, utf8_decode("REPORTE - FLUJO DE CAJA"), 1, 1, 'C', 1);
$pdf->Ln(0);

   // Agregar la fila de fecha y hora apertura de caja
   $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
   $pdf->Cell(150, 7, utf8_decode('FECHA Y HORA DE APERTURA'), 1, 0, 'L', 1); // Columna de subtotales
   $pdf->SetFont('Times', '', 9); // Cambiamos la fuente a negrita
   $pdf->Cell(40, 7, utf8_decode($resultado[0]['fechaaperturacaja']), 1, 1, 'C', 0); // Fecha de apertura caja
      // Agregar la fila de fecha y hora cierre de caja
      $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(150, 7, utf8_decode('FECHA Y HORA DE CIERRE'), 1, 0, 'L', 1); // Columna de 
      $pdf->SetFont('Times', '', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(40, 7, utf8_decode(empty($resultado[0]['fechacierrecaja']) ? 'En curso' : $resultado[0]['fechacierrecaja']), 1, 1, 'C', 0); // Fecha de cierre caja
   // Agregar la fila de saldo inicial en caja
   $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
   $pdf->Cell(150, 7, utf8_decode('SALDO INICIAL DE CAJA'), 1, 0, 'L', 1); // Columna de subtotales
   $pdf->SetFont('Times', '', 9); // Cambiamos la fuente a negrita
   $pdf->Cell(40, 7, utf8_decode($resultado[0]['saldoinicial']), 1, 1, 'C', 0); // Monto de apertura de caja

/* PRIMERA FILA DE CAMPOS (NOMBRES GENERALES) */
$pdf->SetFillColor(211, 211, 211); // Color de fondo
$pdf->SetTextColor(0, 0, 0); // Color del texto
$pdf->SetDrawColor(96, 95, 95); // Color del borde
$pdf->SetFont('Times', 'B', 9);

// Crear las primeras celdas normales con la altura ajustada
$pdf->Cell(8, 14, utf8_decode('N°'), 1, 0, 'C', 1);
$pdf->Cell(32, 14, utf8_decode('FECHA Y HORA'), 1, 0, 'C', 1);
$pdf->Cell(45, 14, utf8_decode('RESPONSABLE'), 1, 0, 'C', 1);
$pdf->Cell(65, 14, utf8_decode('DETALLE'), 1, 0, 'C', 1);

// Aquí hacemos que "Movimientos" abarque dos columnas
$pdf->Cell(40, 7, utf8_decode('MOVIMIENTOS'), 1, 1, 'C', 1); // El subtítulo abarca dos columnas

$pdf->Cell(150); // Esto es la suma de los anchos de las celdas anteriores

// Celdas de la columna movimiento
$pdf->Cell(20, 7, utf8_decode('Egresos'), 1, 0, 'C', 1);
$pdf->Cell(20, 7, utf8_decode('Ingresos'), 1, 1, 'C', 1);

      /* REGISTROS TABLA 1 */
      $i = 0;
      $totalIngresos = 0; 
      $totalEgresos = 0;
   if(empty($resultado[0]['idtransaccion'])){
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(190, 7, utf8_decode("No se tiene registros"), 1, 1, 'C', 0);
   }

   if(!empty($resultado)){

      if(!empty($resultado[0]['idtransaccion'])){
      
         foreach($resultado as $k=>$v){
            $i++;
            /* TABLA */
            $pdf->SetFont('Times', '', 9);
            $pdf->Cell(8, 7, utf8_decode($i), 1, 0, 'C', 0);
            $pdf->Cell(32, 7, utf8_decode($v['fechapago']), 1, 0, 'C', 0);
            $pdf->Cell(45, 7, utf8_decode($v['responsable']), 1, 0, 'C', 0);
            $pdf->Cell(65, 7, utf8_decode($v['descripcion']), 1, 0, 'C', 0);


            // Inicializamos las celdas de Ingresos y Egresos
            $montoIngreso = '';
            $montoEgreso = '';
            
            // Verificamos el tipo de transacción
         if ($v['tipotransaccion'] === 'Ingreso') {
               $montoIngreso = $v['monto'];
               $totalIngresos += $v['monto']; // Sumar al total de ingresos
            } elseif ($v['tipotransaccion'] === 'Egreso') {
               $montoEgreso = $v['monto'];
               $totalEgresos += $v['monto']; // Sumar al total de egresos
            }

            // Imprimimos las celdas de Ingresos y Egresos
            $pdf->Cell(20, 7, utf8_decode($montoEgreso), 1, 0, 'C', 0);
            $pdf->Cell(20, 7, utf8_decode($montoIngreso), 1, 1, 'C', 0);
         
         };

      ;}

      // Agregar la fila de subtotales
      $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(150, 7, utf8_decode('Subtotal'), 1, 0, 'C', 1); // Columna de subtotales
      $pdf->Cell(20, 7, utf8_decode(number_format($totalEgresos, 2)), 1, 0, 'C', 0); // Total de egresos
      $pdf->Cell(20, 7, utf8_decode(number_format($totalIngresos, 2)), 1, 1, 'C', 0); // Total de ingresos

      // Agregar la fila de saldo final de caja
      $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(150, 7, utf8_decode('SALDO FINAL DE CAJA'), 1, 0, 'C', 1); // Columna de subtotales
      $pdf->Cell(40, 7, utf8_decode(number_format($totalIngresos + $resultado[0]['saldoinicial'] - $totalEgresos, 2)), 1, 1, 'C', 0); // Total de ingresos + saldo inidcial - egresos

      // Agregar la fila de observacion
      $pdf->SetFont('Times', 'B', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(40, 15, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1); // Columna de 
      $pdf->SetFont('Times', '', 9); // Cambiamos la fuente a negrita
      $pdf->Cell(150, 15, utf8_decode($resultado[0]['observacioncaja']), 1, 1, 'C', 0); // Observacion de la caja
   }

      $pdf->Ln(5);

date_default_timezone_set('America/La_Paz');
$fecha_actual=date('Y-m-d');
$nombre_archivo='reporte caja siscamargo '.$fecha_actual.'.pdf';
$pdf->Output($nombre_archivo, 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

?>

