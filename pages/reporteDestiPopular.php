<?php
session_start();
// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario




    include "../dao/daoAmortizacion.php";
    //include "../pages/menu/menu.php";

    
   $lista = obtenerDestinosPopulares();


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
            $formato = "d-m-Y";
            $fecha = date($formato,  $timestamp = time());

            //Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',15);
            // Número de página
            $this->Cell(30, 8, utf8_decode($fecha), 0, 0, 'C', 0);
            //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage(); //añade pagina en blanco
    $pdf->SetFont('Times', 'B', 30);
    $pdf->Image('../images/logoSistema.png', 85, 0, 50);

    $pdf->SetXY(45, 15);
    $pdf->Cell(130, 8, utf8_decode('Destinos mas populares'), 0, 0, 'C', 0);
    $pdf->Ln(20);

    $pdf->SetXY(45, 25);
    $pdf->Cell(130, 8, utf8_decode('de acuerdo a la cantidad'), 0, 0, 'C', 0);
    $pdf->Ln(20);

    $pdf->SetXY(46, 35);
    $pdf->Cell(130, 8, utf8_decode('de prestamos'), 0, 0, 'C', 0);
    $pdf->Ln(20);

    $pdf->Ln(15);
    $pdf->SetX(20);

    $pdf->SetFont('Helvetica', 'B', 15);
    $pdf->Cell(30, 8, utf8_decode('N'), 0, 0, 'C', 0);
    $pdf->Cell(60, 8, utf8_decode('Destino'), 0, 0, 'C', 0);
    $pdf->Cell(80, 8, utf8_decode('Cantidad de prestamos'), 0, 1, 'C', 0);
    
    //Formato RGB
    $pdf->SetFillColor(233, 229, 235);
    $pdf->SetDrawColor(61, 61, 61);

    $i = 0;
    $corre = 1;
    $pdf->SetFont('Helvetica', '', 12);
    

    if ($lista == null) {
        $pdf->SetX(20);
        $pdf->Cell(30, 8, utf8_decode($corre), 0, 0, 'C', 1);
        $pdf->Cell(60, 8, utf8_decode(" "), 0, 0, 'C', 1);
        $pdf->Cell(80, 8, utf8_decode(" "), 0, 1, 'C', 1);
        
    } else {
        foreach ($lista as $item) {
            if($item[0] == "1") {
                $destino = "CULTIVO";
            }else if($item[0] == "2") {
                $destino = "PERSONAL";
            }else {
                $destino = "FINANCIAMIENTO";
            }

            $pdf->SetX(20);
            //$pdf->Cell(60,10,utf8_decode('Imprimiendo línea número ').$i,1,1);
           $pdf->Cell(30, 12, utf8_decode($corre), 0, 0, 'C', 1);
            $pdf->Cell(60, 12, $destino, 0, 0, 'C', 1);
            $pdf->Cell(80, 12, $item[1], 0, 1, 'C', 1);         

            $i++;
            $corre++;
        }
    }

    $pdf->Ln(15);
    $pdf->SetX(20);

    //$pdf->SetFont('Helvetica', '', 15);
    //$pdf->Cell(30, 8, utf8_decode($fecha), 0, 0, 'C', 0);


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
