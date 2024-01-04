<?php

require('./fpdf.php');
include "../../config/conexion.php";
include "../util/sqlCuotas.php";


// Obtén el valor de 'id' desde la URL
$idCuota = isset($_GET['id']) ? $_GET['id'] : null;

// Verifica si se proporcionó un ID válido
if ($idCuota === null || !is_numeric($idCuota)) {
    die('Error: ID de cuota no válido.');
}

// Realiza la consulta para obtener la información de la cuota
$consultaCuota = "SELECT
cuota.numeroCuota, 
cuota.fechavencimiento,
cuota.montoCuota, 
prestamo.montoPrestamo, 
prestamo.destinoPrestamo, 
prestamo.fechainicio,
socio.nombre, 
socio.apellido, 
socio.direccion, 
socio.telefono
FROM
cuota
INNER JOIN
prestamo
ON 
   cuota.prestamo = prestamo.id
INNER JOIN
socio
ON 
   prestamo.socio = socio.id
   
where cuota.id=$idCuota";

$resultado = mysqli_query($conexion, $consultaCuota);

// Verifica si la consulta fue exitosa
if (!$resultado) {
    die('Error al obtener la cuota desde la base de datos.');
}

// Obtén los datos de la cuota
$cuota = mysqli_fetch_assoc($resultado);

// Cierra la conexión a la base de datos
mysqli_close($conexion);


$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
// Agregamos los datos de la empresa
$pdf->Cell(5,$textypos,"COOPERATIVA UES SV");
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(10);
$pdf->Cell(5,$textypos,"DE:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"COOPERATIVA UES SV");
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"3ra Av Norte No24 Barrio el calvario");
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"2365-3321");
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"uesCooperativa@gmail.com");

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(75);
$pdf->Cell(5,$textypos,"PARA:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos, $cuota['nombre']. " ". $cuota['apellido']);
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos, $cuota['direccion']);
$pdf->setY(45);$pdf->setX(75);
$pdf->Cell(5,$textypos,$cuota['telefono']);

// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(135);
$pdf->Cell(5,$textypos,"CUOTA #".$cuota['numeroCuota']);
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Fecha: " . date('d/M/Y'));
$fechaVencimientoMySQL = $cuota['fechavencimiento'];

// Convierte la fecha de MySQL a un formato deseado (por ejemplo, "d/m/Y")
$fechaVencimientoFormateada = date('d/m/Y', strtotime($fechaVencimientoMySQL));

$fechaPrestamoMySQL = $cuota['fechainicio'];

// Convierte la fecha de MySQL a un formato deseado (por ejemplo, "d/m/Y")
$fechaPrestamoFormateada = date('d/m/Y', strtotime($fechaPrestamoMySQL));
$pdf->setY(40);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Vencimiento: ".$fechaVencimientoFormateada);
$pdf->setY(45);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Monto del prestamo: $ ".number_format($cuota['montoPrestamo']));
$pdf->setY(50);$pdf->setX(135);
$pdf->Cell(5,$textypos,"Fecha del prestamo: ".$fechaPrestamoFormateada);

/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();
/////////////////////////////
//// Array de Cabecera
$header = array("Cuota No.", "Descripcion","Cuota.","Mora","Total");

    // Column widths
    $w = array(20, 95, 25, 25, 25);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    function calcularMora($fechaVencimiento, $fechaPago, $tasaMora) {
    // Convertir las fechas a objetos DateTime
    $fechaVencimiento = new DateTime($fechaVencimiento);
    $fechaPago = new DateTime($fechaPago);

    // Verificar si la fecha de pago es posterior a la fecha de vencimiento
    if ($fechaPago > $fechaVencimiento) {
        // Calcular la diferencia en días
        $diferenciaDias = $fechaPago->diff($fechaVencimiento)->days;

        // Calcular la mora utilizando la tasa de mora (puede ser una cantidad fija por día o porcentaje)
        $mora = $diferenciaDias * $tasaMora;

        return $mora;
    } else {
        // Si no hay mora, devolver cero
        return 0;
    }
}
$fechaactual = date('Y-m-d');

$mora=calcularMora($cuota['fechavencimiento'],$fechaactual,0.05);
    // Data
    $total = 0;
    $pdf->Cell($w[0], 6, $cuota['numeroCuota'], 1);
    $pdf->Cell($w[1], 6,"Pago de cuota No. ".$cuota['numeroCuota'], 1);
    $pdf->Cell($w[2], 6, "$ " . number_format($cuota['montoCuota'], 2, ".", ","), '1', 0, 'R');
    $pdf->Cell($w[3], 6, "$ " . number_format($mora, 2, ".", ","), '1', 0, 'R');
    $pdf->Cell($w[4], 6, "$ " . number_format($cuota['montoCuota'] + $mora, 2, ".", ","), '1', 0, 'R');
    
    $pdf->Ln();
    $subTotal = $cuota['montoCuota'];
    $total += $cuota['montoCuota'] + $mora;
/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales

/////////////////////////////
$header = array("", "");
$data2 = array(
	array("Subtotal",$subTotal),
	array("Mora", $mora),
	array("Impuesto", 0),
	array("Total", $total),
);
    // Column widths
    $w2 = array(40, 40);
    // Header

    $pdf->Ln();
    // Data
    foreach($data2 as $row)
    {
$pdf->setX(115);
        $pdf->Cell($w2[0],6,$row[0],1);
        $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

        $pdf->Ln();
    }
/////////////////////////////

//$yposdinamic += (count($data2)*10);
$pdf->SetFont('Arial','B',10);    


$pdf->Cell(5,$textypos,"TERMINOS Y CONDICIONES");
$pdf->SetFont('Arial','',10);    

$pdf->setY(115);
$pdf->setX(10);
$pdf->Cell(5,$textypos,"Comprobante de pago.");


$pdf->output();