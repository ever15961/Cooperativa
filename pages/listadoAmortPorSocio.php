
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
    <?php
    // Inicia la sesión
    session_start();

    // Verifica si la variable de sesión "user" está configurada
    if (isset($_SESSION["user"])) {
        // Accede al valor de la variable de sesión "user"
        $nombreUsuario = $_SESSION["user"];
        $rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario


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
            "mora" => "listadoCuotaMora"
        );
        include "../dao/daoPrestamo.php";
        include "../pages/menu/menu.php";
        $codigos = obtenerCodigosClientes();
        if ($_POST) {
            $txtCliente = $_POST['txtClient'];
            $lista = obtenerPrestamosPorSocios($txtCliente);
        } else {
            $lista = obtenerPrestamosPorSocios(0);
        }

        //var_dump($lista);

    ?>
        <hr class="m-0">
        <div class="container-fluid p-4 ">

            <h4 class="text-center bold">Listado de Amortizacion por Cliente</h4>

            <form action="listadoAmortPorSocio.php" method="post">
                <div class="row ">
                    <div class="col-lg-3"></div>
                    <div class="input-group mb-3 col-lg-6">
                    <input type="text"  class="form-control" id="" name="txtClient" placeholder="Código del cliente" list="codigoCliente">
                       <input class="btn ml-3 bg-primary text-light" type="submit" value="Enviar">
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </form>



            <th></th>

            <table id="listadoPrestamos" class="table table-striped mt-3 " style="width:100%">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Descripcion</th>
                        <th>Destino</th>
                        <th>Fecha de inicio</th>
                        <th>Estado</th>
                        <th>Amortizacion</th>

                    </tr>
                </thead>
                <tbody>
    <?php
    $i = 1;

    foreach ($lista as $item) {
        $destinoColor = getDestinoColor($item[3]);
        $estadoColor = getEstadoColor($item[5]);

        echo "<tr>
                <td>" . $i . "</td>
                <td >Prestamos a " . $item[1] . " años a plazo " . getPlazoTexto($item[2]) . "</td>
                <td style='color: $destinoColor;'>" . getDestinoTexto($item[3]) . "</td>
                <td>" . $item[4] . "</td>
                <td style='color: $estadoColor;'>" . getEstadoTexto($item[5]) . "</td>
                <td>
                    <form action='reporteamortizacion.php' method='post' target='_blank'>
                        <input type='hidden' name='txtPrestamo' value='" . $item[0] . "'>
                        <input type='hidden' name='txtCliente' value='" . $txtCliente . "'>
                        <input type='submit' value='Ver' class='btn btn-success'>
                    </form>
                </td>
            </tr>";

        $i++;
    }

    ?>
</tbody>

            </table>
            <datalist id="codigoCliente">
            <?php
            while ($row = $codigos->fetch_assoc()) {
                echo "<option>" . $row["codigoSocio"] . "</option>";
            }

            ?>
        </datalist>
        </div>

        <div class="alert alert-primary col-3 float-right hide" id="alertaMensaje">
            <button class="close" data-dismiss="alert">&times</button>
            <strong>Registro Guardado!</strong>
        </div>

        <script src="../vendor/jquery/jquery.min.js"></script>

        <script src="../js/dataTable/jquery.dataTables.min.js"></script>



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
<?php 
 function getPlazoTexto($plazo) {
    return ($plazo == "1" ? 'mensual' : ($plazo == "2" ? 'trimestral' : ($plazo == "3" ? 'semestral' : '')));
}

function getDestinoTexto($destino) {
    return ($destino == "1" ? 'CULTIVO' : ($destino == "2" ? 'PERSONAL' : ($destino == "3" ? 'FINANCIAMIENTO' : '')));
}

function getDestinoColor($destino) {
    return ($destino == "1" ? 'blue' : ($destino == "2" ? 'purple' : ($destino == "3" ? 'orange' : '')));
}

function getEstadoTexto($estado) {
    return ($estado == "1" ? 'ACTIVO' : 'INACTIVO');
}

function getEstadoColor($estado) {
    return ($estado == "1" ? 'green' : 'red');
}

?>
</html>
