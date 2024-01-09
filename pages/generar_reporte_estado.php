<?php
// Inicia la sesión
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

    include "../dao/daoPrestamo.php";

    $lista = obtenerPrestamosPorEstado();

    //print_r($lista);
    //print_r($lista);

    $listaJS = json_encode($lista);

    //echo $listaJS;

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- Bootstrap core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Fontawesome CSS -->
        <link href="../css/all.css" rel="stylesheet">
        <!-- Owl Carousel CSS -->
        <link href="../css/owl.carousel.min.css" rel="stylesheet">
        <!-- Owl Carousel CSS -->
        <link href="../css/jquery.fancybox.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

        <link href="../css/styleClient.css" rel="stylesheet">

        <!--<link href="../js/dataTable/dataTables.bootstrap5.min.css" rel="stylesheet">-->
        <link href="../js/dataTable/data/jquery.dataTables.min.css" rel="stylesheet">

        <link href="../css/zebra/css/flat/zebra_dialog.css" rel="stylesheet">

        <script src="../js/sweetalert/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>



        <script>
            var datosJS = <?php echo $listaJS; ?>;
        </script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <script type="text/javascript" src="../js/prestamo/prestamoestado.js"></script>
    </head>

    <body>
        <?php

        $url = "../";
        $links = array(
            "movimientos" => "listadoPrestamos",
            "socios" => "listadoSocios",
            "roles" => "listadoRoles",
            "usuarios" => "listadoUsuarios",
            "tipoCuenta" => "listadoTipoCuenta",
            "tipoOperacion" => "listadoTipoOperacion",
            "tipoMovimiento" => "listadoTipoMovimiento",
            "cerrarSesion"  => "cerrar",
            "cuentas" => "listadoCuotas",
            "amorti" => "listadoAmortPorSocio",
            "mora" => "listadoCuotaMora",
            "interes" => "listaInteres",
            "poranio" => "generar_reporte",
            "estadosp" => "pages/generar_reporte_estado"
        );
        include "../pages/menu/menu.php"; ?>
        <h1 class="mt-5 text-center">Información de prestamos</h1>



        <div class="container-full mt-5">
            <div class="card">
                <div class="card-header text-center">Gráfica</div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <form action="reportePrestamoEstadoG.php" method="post" id="hacer_pdf" target="_blank" style="width: 100%;">
                        <input type="hidden" name="variable" id="variable" width="100%">
                        <div id="grafico"></div>
                        <input type="submit" value="Generar PDF" class="btn btn-danger mt-5 mr-5 float-right">
                    </form>
                </div>
            </div>
        </div>




        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../js/imagesloaded.pkgd.min.js"></script>
        <script src="../js/isotope.pkgd.min.js"></script>
        <script src="../js/filter.js"></script>
        <script src="../js/jquery.appear.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/jquery.fancybox.min.js"></script>
        <script src="../js/zebraDialog/zebra_dialog.src.js"></script>

    <?php
} else {
    // Si la variable de sesión "user" no está configurada, muestra un SweetAlert
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
    </body>

    </html>