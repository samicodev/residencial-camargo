<?php

require('./fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->Image('camargo-logo.png', 20, 5, 25);
        $this->SetFont('Times', 'BU', 14);
        $this->Cell(78);
        $this->SetTextColor(11, 12, 19);
        $this->Cell(40, 15, utf8_decode('RESIDENCIAL CAMARGO'), 0, 0, 'C', 0);
        $this->Ln(10);
        $this->SetTextColor(50);

        /* DIRECCION */
        $this->Cell(120);  // mover a la derecha
        $this->SetFont('Times', '', 10);
        $this->Cell(96, 10, utf8_decode("Dirección: Final C./Comercio-Ayacucho"), 0, 0, '', 0);
        $this->Ln(5);

        /* FECHA */
        date_default_timezone_set('America/La_Paz');
        $fecha = date('d/m/Y');
        $this->Cell(10);  // mover a la derecha
        $this->SetFont('Times', '', 10);
        $this->Cell(96, 10, utf8_decode("Fecha: $fecha"), 0, 0, '', 0);
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
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

require_once('../modelo/conexion.php');

$idtransaccion = $_GET['idt'];

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
		WHERE tr.idtransaccion=:idtransaccion";

    $parametros = array(":idtransaccion" => $idtransaccion);

    global $cnx;
    $pre = $cnx->prepare($sql);
    $pre->execute($parametros);
    $resultado = $pre->fetch(PDO::FETCH_ASSOC);


    $monto = $resultado['monto'];


$pdf = new PDF();
$pdf->AddPage("portrait");
$pdf->AliasNbPages();

$pdf->SetFont('Times', '', 12);
$pdf->SetDrawColor(163, 163, 163);



    function numberToWords($num) {
        $ones = [
            '', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez', 
            'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve'
        ];
        
        $tens = [
            '', '', 'Veinte', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'
        ];
        
        $hundreds = [
            '', 'Cien', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos', 'Setecientos', 'Ochocientos', 'Novecientos'
        ];

        if ($num < 20) {
            return $ones[$num];
        } elseif ($num < 100) {
            return $tens[intval($num / 10)] . ($num % 10 ? ' y ' . $ones[$num % 10] : '');
        } elseif ($num < 1000) {
            return $hundreds[intval($num / 100)] . ($num % 100 ? ' ' . numberToWords($num % 100) : '');
        } elseif ($num < 1000000) {
            return numberToWords(intval($num / 1000)) . ' mil' . ($num % 1000 ? ' ' . numberToWords($num % 1000) : '');
        }
        return '';
    }

    function numberWithDecimalsToWords($num) {
        $parts = explode('.', number_format($num, 2, '.', ''));
        $integerPart = intval($parts[0]);
        $decimalPart = intval($parts[1]);
    
        $result = numberToWords($integerPart);
    
        if ($decimalPart > 0) {
            $result .= ' ' . $decimalPart . '/100';
        } else {
            $result .= ' 00/100';
        }
    
        $result .= ' Bolivianos';
    
        return $result;
    }
  
    $cantidadEnPalabras = numberWithDecimalsToWords($monto);

  
/*     require_once('../modelo/conexion.php');
} else {
    header('Location: ../index.php');
} */


// Dibuja un rectángulo
$pdf->SetFillColor(211, 211, 211); // Color de fondo
$pdf->Rect(10, $pdf->GetY()+2, 190, 25, 'F'); // Dibuja el rectángulo con fondo

// Ajusta la posición para el texto
$pdf->SetXY(15, $pdf->GetY() + 5); 

$pdf->SetFont('Times', 'B', 12);
$pdf->SetTextColor(0, 0, 0); // Color del texto
$pdf->Cell(0, 5, utf8_decode('COMPROBANTE DE PAGO'), 0, 1, 'C'); // Título centrado
$pdf->Ln(1); // Salto de línea para espacio adicional

$pdf->Cell(10); // Espacio vacío en el medio
// Texto alineado a la izquierda
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 7, utf8_decode('Lugar y Fecha: Cobija, ' . $resultado['fecha']), 0, 0, 'L'); 
$pdf->Cell(70); // Espacio vacío en el medio
$pdf->Cell(0, 7, utf8_decode('Habitación N°: ' . $resultado['codigohabitacion']), 0, 1, 'L'); 

$pdf->Cell(10); // Espacio vacío en el medio
$pdf->Cell(60, 7, utf8_decode('Nombre: ' . $resultado['nombcomp']), 0, 0, 'L'); 
$pdf->Cell(70); // Espacio vacío en el medio
$pdf->Cell(0, 7, utf8_decode('C.I/Pasaporte: ' . $resultado['nrodocumento']), 0, 1, 'L'); 
$pdf->Ln(7);

// Continúa con el resto de tu contenido...
$pdf->SetFillColor(211, 211, 211);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetDrawColor(96, 95, 95);
$pdf->SetFont('Times', 'B', 9);

// Crear las primeras celdas normales con la altura ajustada
$pdf->Cell(8, 14, utf8_decode('N°'), 1, 0, 'C', 1);
$pdf->Cell(22, 14, utf8_decode('CANTIDAD'), 1, 0, 'C', 1);
$pdf->Cell(80, 14, utf8_decode('DESCRIPCIÓN'), 1, 0, 'C', 1);
$pdf->Cell(40, 14, utf8_decode('UNIDAD DE MEDIDA'), 1, 0, 'C', 1);
$pdf->Cell(40, 14, utf8_decode('SUBTOTAL'), 1, 1, 'C', 1);

$pdf->SetFont('Times', '', 9); // Fuente normal (sin negrita)
// Segunda fila (Datos)
$pdf->Cell(8, 10, utf8_decode('1'), 1, 0, 'C', 0); // Datos para la columna N°
$pdf->Cell(22, 10, utf8_decode('1'), 1, 0, 'C', 0); // Datos para la columna CANTIDAD
$pdf->Cell(80, 10, utf8_decode('Cobro de Servicio de Hospedaje.'), 1, 0, 'C', 0); // Datos para la columna DESCRIPCIÓN
$pdf->Cell(40, 10, utf8_decode('Unidad (Servicios)'), 1, 0, 'C', 0); // Datos para la columna UNIDAD DE MEDIDA
$pdf->Cell(40, 10, utf8_decode($resultado['monto']), 1, 1, 'C', 0); // Datos para la columna SUBTOTAL

// Agregar una fila de total
$pdf->SetFont('Times', 'B', 9); // Fuente en negrita para el total
$pdf->Cell(150, 7, utf8_decode('TOTAL (BS)'), 1, 0, 'C', 0); // Ocupa las 4 primeras columnas (8 + 22 + 80 + 40 = 150)
$pdf->Cell(40, 7, utf8_decode($resultado['monto']), 1, 1, 'C', 0); // Total en la última columna


$pdf->Ln(3);

$pdf->Cell(10); // Espacio vacío en el medio
// Texto alineado a la izquierda
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 7, utf8_decode('Son: ' . $cantidadEnPalabras), 0, 0, 'L'); 
$pdf->Cell(60); // Espacio vacío en el medio
$pdf->Cell(0, 7, utf8_decode('Recepcionista: ' . $resultado['responsable']), 0, 1, 'L');

$pdf->Cell(10); // Espacio vacío en el medio
// Texto alineado a la izquierda
$pdf->SetFont('Times', '', 10);
$pdf->Cell(60, 7, utf8_decode('Metodo de Pago: ' . $resultado['metodopago']), 0, 0, 'L'); 
$pdf->Cell(60); // Espacio vacío en el medio
$pdf->Cell(0);


$pdf->Ln(25);
$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(190, 7, utf8_decode('¡Gracias por su preferencia!. Para cualquier consulta, no dude en comunicarse con nosotros.'), 0, 0, 'C'); 

date_default_timezone_set('America/La_Paz');
$fechaActual = date('d-m-Y');
$nombre_archivo = 'ComprobantePago ' . $fechaActual . '.pdf';
$pdf->Output($nombre_archivo, 'I'); // nombreDescarga, Visor(I->visualizar - D->descargar)
?>
