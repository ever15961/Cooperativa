<?php
session_start();
// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario



    include "../daoPrestamo.php";
    //include "../pages/menu/menu.php";

  // Obtén el valor de 'id' desde la URL
$idPrestamo = isset($_GET['id']) ? $_GET['id'] : null;

// Verifica si se proporcionó un ID válido
if ($idPrestamo === null || !is_numeric($idPrestamo)) {
    die('Error: ID de prestamo no válido.');
}
    $listaE = encabezado($idPrestamo);
    $listaAM = obtenerDatos($idPrestamo);


    require('../fpdf/fpdf.php');

    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            // Logo
            //$this->Image('logo.png',10,8,33);
            // Arial bold 15
            //$this->SetFont('Arial','B',15);
            // Movernos a la derecha
            //$this->Cell(80);
            // Título
            //$this->Cell(30,10,'Title',1,0,'C');
            // Salto de línea
            //$this->Ln(20);
        }

        // Pie de página
        function Footer()
        {
            // Posición: a 1,5 cm del final
            //$this->SetY(-15);
            // Arial italic 8
            //$this->SetFont('Arial','I',8);
            // Número de página
            //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF('L');
    $pdf->AliasNbPages();
    $pdf->AddPage(); //añade pagina en blanco
    $pdf->SetFont('Times', 'B', 30);
    $pdf->Image('../../images/logoSistema.png', 120, 0, 60);

    $pdf->SetXY(80, 15);
    $pdf->Cell(130, 8, utf8_decode('Prestamo'), 0, 0, 'C', 0);
    $pdf->Ln(20);

       // Agrega el campo de código de préstamo
       $pdf->SetFont('Times', 'B', 15);
       $pdf->SetX(30);
       $pdf->Cell(100, 8, utf8_decode('Código de Préstamo: ' . $listaE[0][1]), 0, 1, 'L', 0);

       $pdf->SetFont('Times', 'B', 15);
       $pdf->SetX(30);
       $pdf->Cell(100, 8, utf8_decode('Fecha del prestamo: ' . $listaE[0][10]), 0, 1, 'L', 0);
   
    $pdf->SetFont('Times', 'B', 15);
    $pdf->SetX(30);
    $pdf->Cell(100, 8, utf8_decode('Información de prestamo'), 0, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(30);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Nombre', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($listaE[0][7]), 1, 0, 'L', 0);

    $pdf->SetX(145);

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(40, 8, 'Monto', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(40, 8, "$" . utf8_decode($listaE[0][2]), 1, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(30);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Apellido', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($listaE[0][8]), 1, 0, 'L', 0);

    $pdf->SetX(145);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Destino', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    
    if($listaE[0][6] == "1") {
        $destino = 'Cultivo';
    }else if($listaE[0][6] == "2") {
        $destino = 'Personal';
    }else {
        $destino = 'Financiamiento';
    }
   $pdf->Cell(40, 8, $destino, 1, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(30);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, utf8_decode('Dirección'), 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($listaE[0][9]), 1, 0, 'L', 0);

    $pdf->SetX(145);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Cuota anivelada', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);

    $pdf->Cell(40, 8, $listaAM[0][2], 1, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(30);

    if($listaE[0][5] == "1") {
        $periodo = "mensual";
        $frecuencia = 12;
    }else if($listaE[0][5] == "2") {
        $periodo = "trimestral";
        $frecuencia = 4;
    }else {
        $periodo = "semestral";
        $frecuencia = 2;
    }

    $periodoCalculado = $frecuencia * $listaE[0][4];

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Periodos ' . $periodo, 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($periodoCalculado), 1, 0, 'L', 0);

    $pdf->SetX(145);

    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(40, 8, 'Tasa interes anual', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(40, 8, utf8_decode($listaE[0][3]) . "%", 1, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(30);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, utf8_decode('Tiempo en años'), 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($listaE[0][4]), 1, 0, 'L', 0);

    $pdf->SetX(145);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(40, 8, 'Frecuencia', 1, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
  
   $pdf->Cell(40, 8, $frecuencia, 1, 0, 'L', 0);

    $pdf->Ln(15);
    $pdf->SetX(30);

    $pdf->SetFont('Helvetica', 'B', 15);
    $pdf->Cell(20, 8, utf8_decode('N'), 1, 0, 'C', 0);
    $pdf->Cell(42, 8, utf8_decode('Fecha'), 1, 0, 'C', 0);
    $pdf->Cell(42, 8, utf8_decode('Cuota'), 1, 0, 'C', 0);
    $pdf->Cell(42, 8, utf8_decode('Capital'), 1, 0, 'C', 0);
    $pdf->Cell(42, 8, utf8_decode('Interes'), 1, 0, 'C', 0);
    $pdf->Cell(42, 8, utf8_decode('Saldo'), 1, 1, 'C', 0);

    //Formato RGB
    $pdf->SetFillColor(233, 229, 235);
    $pdf->SetDrawColor(61, 61, 61);

    $tamanio = count($listaE);
    $i = 1;
    $pdf->SetFont('Helvetica', '', 12);
    foreach ($listaAM as $item) {
        $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $item[1]);
            $fechaFormateada = $fecha->format('d/m/Y'); // Reemplaza 'formato_deseado' con el formato que necesitas
        $pdf->SetX(30);
        //$pdf->Cell(60,10,utf8_decode('Imprimiendo línea número ').$i,1,1);
        if($i == 0) {
            $pdf->Cell(20, 8, utf8_decode($i), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, utf8_decode(" "), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, utf8_decode(" "), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, utf8_decode(" "), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, utf8_decode(" "), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, "$". utf8_decode($listaE[0][1]), 1, 1, 'C', 1);
        }else {

    
            

            
            $pdf->Cell(20, 8, utf8_decode($i), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, $fechaFormateada, 1, 0, 'C', 1); 
            $pdf->Cell(42, 8, "$". number_format($item[2], 4), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, "$". number_format($item[3], 4), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, "$". number_format($item[4], 4), 1, 0, 'C', 1);
            $pdf->Cell(42, 8, "$". number_format($item[6], 4), 1, 1, 'C', 1);
        }

        $i++;

    }
    $pdf->Output();
} else {
    echo "<script>
              Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'Usuario no identificado. Redirigiendo a la página de inicio de sesión...',
                  showConfirmButton: true
              }).then(function() {
                  window.location.href = '../index.php';
              });
          </script>";
}
?>