<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      $this->Image('camargo-logo.png', 20, 5, 30); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Times', 'BU', 18); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(85); // Movernos a la derecha
      $this->SetTextColor(11, 12, 19); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode('RESIDENCIAL CAMARGO'), 0, 0, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(10); // Salto de línea
      $this->SetTextColor(50); //color

      /* DIRECCION */
      $this->Cell(200);  // mover a la derecha
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
      $this->Cell(200);  // mover a la derecha
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
$pdf->AddPage("landscape"); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFont('Times', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

require_once('../modelo/conexion.php'); //llamamos a la conexion BD

   date_default_timezone_set('America/La_Paz');
   $fechaActual = date('Y-m-d H:i:s');

   $sql = "SELECT hue.nombcomp as 'huesped', hue.nacionalidad, hue.nrodocumento, hab.codigohabitacion as 'habitacion', hos.id_hospedar,hospe.id_hospedaje, DATE_FORMAT(hos.fechaingreso,'%d/%m/%Y  %h:%i %p') as 'fechaingreso', DATE_FORMAT(DATE(hos.fechasalida), '%d/%m/%Y  %h:%i %p') as 'fechasalida', hos.resante, hos.motviaje, hos.estado
   FROM huesped hue 
   INNER JOIN hospedar hos 
   ON hue.id_huesped=hos.id_huesped
   INNER JOIN hospedaje hospe
   ON hos.id_hospedaje=hospe.id_hospedaje
   INNER JOIN habitacion hab 
   ON hospe.id_habitacion=hab.id_habitacion        
   WHERE hue.estado=1 AND hos.estado=1";

   $parametros = array();

   if($fechaActual!=""){
      $sql .= " AND hos.fechaingreso BETWEEN DATE_SUB(NOW(), INTERVAL 24 HOUR) AND :fechaactual";
      $parametros[':fechaactual'] = $fechaActual; 
   }


   global $cnx;
   $pre = $cnx->prepare($sql);
   $pre->execute($parametros);
   $resultado = $pre;
	$resultado = $resultado->fetchAll(PDO::FETCH_NAMED);

   /* TITULO DE LA TABLA 1 */
      //color
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(211, 211, 211); //colorFondo
      $pdf->SetDrawColor(96, 95, 95); //colorBorde
      $pdf->Cell(0.01); // mover a la derecha
      $pdf->SetFont('Times', 'B', 12);
      $pdf->Cell(277, 7, utf8_decode("INGRESO DE HUÉSPEDES"), 1, 1, 'C',1);
      $pdf->Ln(0);

      /* CAMPOS DE LA TABLA 1 */
      //color
      $pdf->SetFillColor(211, 211, 211); //colorFondo
      $pdf->SetTextColor(0, 0, 0); //colorTexto
      $pdf->SetDrawColor(96, 95, 95); //colorBorde
      $pdf->SetFont('Times', 'B', 9);
      $pdf->Cell(10, 7, utf8_decode('N°'), 1, 0, 'C', 1);
      $pdf->Cell(60, 7, utf8_decode('NOMBRE Y APELLIDOS'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('NACIONALIDAD'), 1, 0, 'C', 1);
      $pdf->Cell(27, 7, utf8_decode('CI/PASAPORTE'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('NRO HABITACION'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('FECHA DE INGRESO'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('PROCEDENCIA'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('MOTIVO DE VIAJE'), 1, 1, 'C', 1);

      /* REGISTROS TABLA 1 */
      $i = 0;

   if(!empty($resultado)){
      foreach($resultado as $k=>$v){
         $i++;
         /* TABLA */
         $pdf->SetFont('Times', '', 9);
         $pdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C', 0);
         $pdf->Cell(60, 7, utf8_decode($v['huesped']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['nacionalidad']), 1, 0, 'C', 0);
         $pdf->Cell(27, 7, utf8_decode($v['nrodocumento']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['habitacion']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['fechaingreso']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['resante']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['motviaje']), 1, 1, 'C', 0);

      };
   }else{
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(277, 7, utf8_decode("No se tiene registros"), 1, 1, 'C', 0);
   }

      $pdf->Ln(5);

      /* CONSULTA SQL TABLA 2 */

      $sql2 = "SELECT hue.nombcomp as 'huesped', hue.nacionalidad, hue.nrodocumento, hab.codigohabitacion as 'habitacion', hos.id_hospedar, hospe.id_hospedaje, DATE_FORMAT(hos.fechaingreso, '%d/%m/%Y  %h:%i %p') as 'fechaingreso', DATE_FORMAT(DATE(hos.fechasalida), '%d/%m/%Y  %h:%i %p') as 'fechasalida', hos.resante, hos.motviaje, hos.estado
      FROM huesped hue 
      INNER JOIN hospedar hos 
      ON hue.id_huesped=hos.id_huesped
      INNER JOIN hospedaje hospe
      ON hos.id_hospedaje=hospe.id_hospedaje
      INNER JOIN habitacion hab 
      ON hospe.id_habitacion=hab.id_habitacion        
      WHERE hue.estado=1 AND hos.estado=1";

      $parametros2 = array();

      if($fechaActual!=""){
			$sql2 .= " AND hos.fechasalida IS NULL AND hos.fechaingreso < :fechaactual - INTERVAL 24 HOUR";
			$parametros2[':fechaactual'] = $fechaActual; 
		}

      /* AND hos.fechaingreso < NOW() - INTERVAL 24 HOUR 
         hos.fechaingreso < :fecha
      */

      global $cnx;
      $pre = $cnx->prepare($sql2);
      $pre->execute($parametros2);
      $resultado2 = $pre;
      $resultado2 = $resultado2->fetchAll(PDO::FETCH_NAMED);

      /* TITULO DE LA TABLA 2 */
      //color
      $pdf->SetTextColor(0, 0, 0);
      $pdf->SetFillColor(211, 211, 211); //colorFondo
      $pdf->SetDrawColor(96, 95, 95); //colorBorde
      $pdf->Cell(0.01); // mover a la derecha
      $pdf->SetFont('Times', 'B', 12);
      $pdf->Cell(277, 7, utf8_decode("HUÉSPEDES QUE CONTINÚAN"), 1, 1, 'C',1);
      $pdf->Ln(0);

      /* CAMPOS DE LA TABLA 2 */
      //color
      $pdf->SetFillColor(211, 211, 211); //colorFondo
      $pdf->SetTextColor(0, 0, 0); //colorTexto
      $pdf->SetDrawColor(96, 95, 95); //colorBorde
      $pdf->SetFont('Times', 'B', 9);
      $pdf->Cell(10, 7, utf8_decode('N°'), 1, 0, 'C', 1);
      $pdf->Cell(60, 7, utf8_decode('NOMBRE Y APELLIDOS'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('NACIONALIDAD'), 1, 0, 'C', 1);
      $pdf->Cell(27, 7, utf8_decode('CI/PASAPORTE'), 1, 0, 'C', 1);
      $pdf->Cell(30, 7, utf8_decode('NRO HABITACION'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('FECHA DE INGRESO'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('PROCEDENCIA'), 1, 0, 'C', 1);
      $pdf->Cell(40, 7, utf8_decode('MOTIVO DE VIAJE'), 1, 1, 'C', 1);

      /* REGISTROS TABLA 2 */
   $i = 0;

   if(!empty($resultado2)){
      foreach($resultado2 as $k=>$v){
         $i++;
         /* TABLA */
         $pdf->SetFont('Times', '', 9);
         $pdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C', 0);
         $pdf->Cell(60, 7, utf8_decode($v['huesped']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['nacionalidad']), 1, 0, 'C', 0);
         $pdf->Cell(27, 7, utf8_decode($v['nrodocumento']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['habitacion']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['fechaingreso']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['resante']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['motviaje']), 1, 1, 'C', 0);

      };
   }else{
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(277, 7, utf8_decode("No se tiene registros"), 1, 1, 'C', 0);
   }

   $pdf->Ln(5);

   /* CONSULTA SQL TABLA 3 */

   $sql3 = "SELECT hue.nombcomp as 'huesped', hue.nacionalidad, hue.nrodocumento, hab.codigohabitacion as 'habitacion', hos.id_hospedar, hospe.id_hospedaje, DATE_FORMAT(hos.fechaingreso, '%d/%m/%Y  %h:%i %p') as 'fechaingreso', DATE_FORMAT(hos.fechasalida, '%d/%m/%Y  %h:%i %p') as 'fechasalida', hos.resante, hos.motviaje, hos.estado
      FROM huesped hue 
      INNER JOIN hospedar hos 
      ON hue.id_huesped=hos.id_huesped
      INNER JOIN hospedaje hospe
      ON hos.id_hospedaje=hospe.id_hospedaje
      INNER JOIN habitacion hab 
      ON hospe.id_habitacion=hab.id_habitacion        
      WHERE hue.estado=1 AND hos.estado=1";

   $parametros3 = array();

   if($fechaActual!=""){
      $sql3 .= " AND hos.fechasalida BETWEEN DATE_SUB(NOW(), INTERVAL 24 HOUR) AND :fechaactual";
      $parametros3[':fechaactual'] = $fechaActual; 
   }

   global $cnx;
   $pre = $cnx->prepare($sql3);
   $pre->execute($parametros3);
   $resultado3 = $pre;
   $resultado3 = $resultado3->fetchAll(PDO::FETCH_NAMED);

   /* TITULO DE LA TABLA 3 */
   //color
   $pdf->SetTextColor(0, 0, 0);
   $pdf->SetFillColor(211, 211, 211); //colorFondo
   $pdf->SetDrawColor(96, 95, 95); //colorBorde
   $pdf->Cell(0.01); // mover a la derecha
   $pdf->SetFont('Times', 'B', 12);
   $pdf->Cell(277, 7, utf8_decode("SALIDA DE HUÉSPEDES"), 1, 1, 'C',1);
   $pdf->Ln(0);

   /* CAMPOS DE LA TABLA 3 */
   //color
   $pdf->SetFillColor(211, 211, 211); //colorFondo
   $pdf->SetTextColor(0, 0, 0); //colorTexto
   $pdf->SetDrawColor(96, 95, 95); //colorBorde
   $pdf->SetFont('Times', 'B', 9);
   $pdf->Cell(10, 7, utf8_decode('N°'), 1, 0, 'C', 1);
   $pdf->Cell(60, 7, utf8_decode('NOMBRE Y APELLIDOS'), 1, 0, 'C', 1);
   $pdf->Cell(30, 7, utf8_decode('NACIONALIDAD'), 1, 0, 'C', 1);
   $pdf->Cell(27, 7, utf8_decode('CI/PASAPORTE'), 1, 0, 'C', 1);
   $pdf->Cell(30, 7, utf8_decode('NRO HABITACION'), 1, 0, 'C', 1);
   $pdf->Cell(40, 7, utf8_decode('FECHA DE SALIDA'), 1, 0, 'C', 1);
   $pdf->Cell(40, 7, utf8_decode('PROCEDENCIA'), 1, 0, 'C', 1);
   $pdf->Cell(40, 7, utf8_decode('MOTIVO DE VIAJE'), 1, 1, 'C', 1);

   /* REGISTROS TABLA 3 */
   $i = 0;

   if(!empty($resultado3)){
      foreach($resultado3 as $k=>$v){
         $i ++;
         /* TABLA */
         $pdf->SetFont('Times', '', 9);
         $pdf->Cell(10, 7, utf8_decode($i), 1, 0, 'C', 0);
         $pdf->Cell(60, 7, utf8_decode($v['huesped']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['nacionalidad']), 1, 0, 'C', 0);
         $pdf->Cell(27, 7, utf8_decode($v['nrodocumento']), 1, 0, 'C', 0);
         $pdf->Cell(30, 7, utf8_decode($v['habitacion']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['fechasalida']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['resante']), 1, 0, 'C', 0);
         $pdf->Cell(40, 7, utf8_decode($v['motviaje']), 1, 1, 'C', 0);

      };
   }else{
      $pdf->SetFont('Times', '', 9);
      $pdf->Cell(277, 7, utf8_decode("No se tiene registros"), 1, 1, 'C', 0);
   }


$nombre_archivo='reporte siscamargo '.$fechaActual.'.pdf';
$pdf->Output($nombre_archivo, 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

?>

