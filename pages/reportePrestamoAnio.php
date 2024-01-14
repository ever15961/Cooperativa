
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

    

    if($_POST) {
        $grafico = $_POST['variable'];
    }
   //$lista = obtenerDestinosPopulares();


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
    $pdf->Cell(130, 8, utf8_decode('Gráfico de Prestamos'), 0, 0, 'C', 0);
    $pdf->Ln(20);

    $img = explode(",", $grafico, 2)[1];
    $pic = 'data://text/plain;base64,' . $img;
    $pdf->Image($pic, 20,50,250,0,'png');

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
