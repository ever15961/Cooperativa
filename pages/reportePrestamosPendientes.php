<?php
session_start();
// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario

    // Verifica el rol y redirige si es necesario
    if ($rolUsuario === "Empleado") {
        // Si el rol es "Empleado", redirige a otra página o realiza alguna acción
        header("Location: listadoPrestamosEmp.php");
        exit();
    }


    include "../dao/daoAmortizacion.php";
    //include "../pages/menu/menu.php";

    if ($_GET) {
       $txtSocio = $_GET['id'];
    }

    $socio = obtenerSocioP($txtSocio);
    $listaPrestamosP = obtenerPrestamosPendientes($txtSocio);
    //print_r($listaPrestamosP);


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
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage(); //añade pagina en blanco
    $pdf->SetFont('Times', 'B', 30);
    $pdf->Image('../images/logoSistema.png', 80, 0, 50);

    $pdf->SetXY(45, 15);
    $pdf->Cell(130, 8, utf8_decode('Prestamos pendientes'), 0, 0, 'C', 0);
    $pdf->Ln(20);

    $pdf->SetFont('Times', 'B', 15);
    $pdf->SetX(10);
    $pdf->Cell(100, 8, utf8_decode('Información de prestamo'), 0, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(5);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(25, 8, 'Codigo:', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($socio[0][0]), 0, 0, 'L', 0);

    $pdf->SetX(120);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(25, 8, 'Nombre:', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(40, 8, utf8_decode($socio[0][1]), 0, 0, 'L', 0);

    $pdf->Ln(10);
    $pdf->SetX(5);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(25, 8, 'Direccion:', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(75, 8, utf8_decode($socio[0][3]), 0, 0, 'L', 0);

    $pdf->SetX(120);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(25, 8, 'Apellido:', 0, 0, 'C', 0);
    $pdf->SetFont('Times', '', 12);
    $pdf->Cell(40, 8, utf8_decode($socio[0][2]), 0, 0, 'L', 0);

    $pdf->Ln(15);
    $pdf->SetX(5);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(15, 8, utf8_decode('N'), 1, 0, 'C', 0);
    $pdf->Cell(30, 8, utf8_decode('Fecha inicio'), 1, 0, 'C', 0);
    $pdf->Cell(60, 8, utf8_decode('Destino'), 1, 0, 'C', 0);
    $pdf->Cell(30, 8, utf8_decode('Monto'), 1, 0, 'C', 0);
    $pdf->Cell(25, 8, utf8_decode('T. interes'), 1, 0, 'C', 0);
    $pdf->Cell(40, 8, utf8_decode('Saldo pendiente'), 1, 1, 'C', 0);

    //Formato RGB
    $pdf->SetFillColor(233, 229, 235);
    $pdf->SetDrawColor(61, 61, 61);

    $i = 0;
    $contador = 1;

    $pdf->SetFont('Helvetica', '', 12);

    if ($listaPrestamosP == null) {
        $pdf->SetX(5);
        $pdf->Cell(15, 8, utf8_decode($contador), 1, 0, 'C', 1);
        $pdf->Cell(30, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(60, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(30, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(25, 8, " ", 1, 1, 'C', 1);
        $pdf->Cell(40, 8, utf8_decode(" "), 1, 0, 'C', 1);
    } else {
        foreach ($listaPrestamosP as $item) {
          if($item[5]==1){
            $saldoPendiente=$item[2];
          }else{
            $saldoPendiente=$item[4];
          }

            $pdf->SetX(5);
            //$pdf->Cell(60,10,utf8_decode('Imprimiendo línea número ').$i,1,1);
            $pdf->Cell(15, 12, utf8_decode($contador), 1, 0, 'C', 1);
            $pdf->Cell(30, 12, $item[0], 1, 0, 'C', 1);
            $pdf->Cell(60, 12, $item[1], 1, 0, 'C', 1);
            $pdf->Cell(30, 12, "$" . number_format($item[2], 4), 1, 0, 'C', 1);
            $pdf->Cell(25, 12, utf8_decode($item[3]) . "%", 1, 0, 'C', 1);
            $pdf->Cell(40, 12, "$" . number_format($saldoPendiente, 4), 1, 1, 'C', 1);

            $i++;
            $contador++;
        }
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
