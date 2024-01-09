<?php
session_start();
// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario

    if ($rolUsuario === "Socio") {
        // Si el rol es "Empleado", redirige a otra página o realiza alguna acción
        header("Location: ../index.php");
        exit();
    }


    include "../dao/daoAmortizacion.php";
    //include "../pages/menu/menu.php";

    if ($_GET) {
       $txtSocio = $_GET['id'];
    }

    $socio = obtenerSocioP($txtSocio);
    $listaPrestamos = obtenerTodosLosPrestamos($txtSocio);
    //print_r($listaPrestamos);


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
    $pdf->Cell(130, 8, utf8_decode('Listado Prestamos'), 0, 0, 'C', 0);
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
    $pdf->SetX(3);

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(10, 8, utf8_decode('N'), 1, 0, 'C', 0);
    $pdf->Cell(75, 8, utf8_decode('Descripcion'), 1, 0, 'C', 0);
    $pdf->Cell(37, 8, utf8_decode('Destino'), 1, 0, 'C', 0);
    $pdf->Cell(25, 8, utf8_decode('Fecha'), 1, 0, 'C', 0);
    $pdf->Cell(15, 8, utf8_decode('Tasa'), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode('Monto'), 1, 0, 'C', 0);
    $pdf->Cell(20, 8, utf8_decode('Estado'), 1, 1, 'C', 0);

    //Formato RGB
    $pdf->SetFillColor(233, 229, 235);
    $pdf->SetDrawColor(61, 61, 61);

    $i = 0;
    $contador = 1;

    $pdf->SetFont('Helvetica', '', 12);
    
    $pdf->SetX(3);

    if ($listaPrestamos == null) {
        $pdf->Cell(10, 8, utf8_decode($contador), 1, 0, 'C', 1);
        $pdf->Cell(75, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(37, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(25, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(15, 8, " ", 1, 0, 'C', 1);
        $pdf->Cell(20, 8, utf8_decode(" "), 1, 0, 'C', 1);
        $pdf->Cell(20, 8, utf8_decode(" "), 1, 1, 'C', 1);
    } else {
        foreach ($listaPrestamos as $item) {


            $concepto = "";
            if($item[2] == "1") {
                $concepto = "mensual";
            }else if($item[2] == "2") {
                $concepto = "trimestral";
            }else {
                $concepto = "semestral";
            }

            $pdf->SetX(3);

            $pdf->Cell(10, 15, $contador, 1, 0, 'C', 1);
            $pdf->Cell(75, 15, "Prestamos a " . $item[1] . utf8_decode(" años a plazo ") . $concepto, 1, 0, 'C', 1);
            $pdf->Cell(37, 15, $item[3], 1, 0, 'C', 1);
            $pdf->Cell(25, 15, utf8_decode($item[4]), 1, 0, 'C', 1);
            $pdf->Cell(15, 15, $item[7] . "%", 1, 0, 'C', 1);
            $pdf->Cell(20, 15, "$" . $item[6], 1, 0, 'C', 1);
            $pdf->Cell(20, 15, ($item[5] == "1") ? "En curso" : "Pagado", 1, 1, 'C', 1);

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
