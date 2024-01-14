
<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listados Préstamos</title>

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

</head>


<body>
    <script src="../js/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>

    <?php
    session_start();
    // Verifica si la variable de sesión "user" está configurada
    if (isset($_SESSION["user"])) {
        // Accede al valor de la variable de sesión "user"
        $nombreUsuario = $_SESSION["user"];
        $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario

        // Verifica el rol y redirige si es necesario
      if($rolUsuario === "Socio"){
            header("Location: ../index.php");
            exit();
        }

        
        include "../dao/daoAmortizacion.php";
        //include "../pages/menu/menu.php";

        if($_POST) {
            $txtPrestamo = $_POST['txtPrestamo'];
            $txtCliente = $_POST['txtCliente'];
        }
        $listaE = encabezado_amortizacion($txtPrestamo);
        $listaAM = obtenerAmortizacion($txtPrestamo, $txtCliente);


    ?>
        <hr class="m-0">
        <div class="container-fluid p-4 ">

            <h4 class="text-center bold">Amortizacion de prestamo</h4>
            <div class="row">
            <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <p><b>Nombre:</b> <?php echo $listaE[0][6]; ?> </p>
                    <p><b>Apellido:</b> <?php echo $listaE[0][7]; ?></p>
                    <p><b>Direccion:</b> <?php echo $listaE[0][8]; ?></p>
                    <p><b>Monto:</b> <?php echo $listaE[0][1]; ?></p>
                    <p><b>Destino:</b> <?php echo ($listaE[0][5] == "1" ? 'CULTIVO' : ''), ($listaE[0][5] == "2" ? 'PERSONAL' : ''), ($listaE[0][5] == "3" ? 'FINANCIAMIENTO' : ''); ?></p>

                    <table id="listadoAmortizacion" class="table table-striped mt-3 " style="width:100%">

                        <tbody>
                            <?php

                            foreach ($listaE as $item) {
                                $monto = $item[1];
                                $tasaAnual =  $item[2];
                                $tiempo = $item[3];

                                if ($item[4] == "1") {
                                    $frecuencia = 12;
                                } else if ($item[4] == "2") {
                                    $frecuencia = 4;
                                } else {
                                    $frecuencia = 2;
                                }

                                $periodo = $tiempo * $frecuencia;

                                echo "<tr><td> Valor total del prestamo </td><td>" . $monto . "</td></tr>";
                                echo "<tr><td> Tasa de interes anual </td><td>" . $tasaAnual . "%" . "</td></tr>";
                                echo "<tr><td> Tiempo en años </td><td>" . $tiempo . "</td></tr>";
                                echo "<tr><td> Frecuencia </td><td>" . $frecuencia . "</td></tr>";
                                echo "<tr><td> Periodos " . ($item[4] == "1" ? 'mensual' : ''), ($item[4] == "2" ? 'trimestral' : ''), ($item[4] == "3" ? 'semestral' : '') . "</td><td>" . $periodo . "</td></tr>";
                                echo "<tr><td> Cuota nivelada </td><td>" . $listaAM[0][1] . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <hr class="m-0">
                </div>
                <div class="col-lg-2"></div>
                
            </div>

            <h4 class="text-center bold my-3">CUADRO DE AMORTIZACION DE PRESTAMO</h4>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <table id="" class="table table-striped mt-3 " style="width:100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Cuota</th>
                                <th>Capital</th>
                                <th>Intereses</th>
                                <th>Saldo</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /*
                        id cuenta
                        monto
                        principal
                        intereses
                        estado
                        saldo pendiente
                    */
                            $i = 0;

                            foreach ($listaAM as $item) {
                                if ($i == 0) {
                                    echo "<tr>
                            <td>" . $i . "</td>
                            <td>" . " " . "</td>
                            <td>" . " " . "</td>
                            <td>" . " " . "</td>
                            <td>" . $monto . "</td>";
                                } else {
                                    echo "<tr>
                                <td>" . $i . "</td>
                                <td>" . $item[1] . "</td>
                                <td>" . $item[2] . "</td>
                                <td>" . $item[3] . "</td>
                                <td>" . $item[5] . "</td>";
                                }

                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-2"></div>
            </div>


        </div>

        <div class="alert alert-primary col-3 float-right hide" id="alertaMensaje">
            <button class="close" data-dismiss="alert">&times</button>
            <strong>Registro Guardado!</strong>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>

        <script src="../js/dataTable/jquery.dataTables.min.js"></script>
        <script src="../js/prestamo/prestamoScript.js"></script>


        <!-- Bootstrap core JavaScript -->
        <?php include "modal/modalListaPrestamo.php" ?>

        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../js/imagesloaded.pkgd.min.js"></script>
        <script src="../js/isotope.pkgd.min.js"></script>
        <script src="../js/filter.js"></script>
        <script src="../js/jquery.appear.js"></script>
        <script src="../js/owl.carousel.min.js"></script>
        <script src="../js/jquery.fancybox.min.js"></script>
        <script src="../js/zebraDialog/zebra_dialog.src.js"></script>
        <script src="../js/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>


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
