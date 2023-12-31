<!DOCTYPE html>
<html lang="es">


<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>Listados Préstamos en mora</title>
    
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

    if($rolUsuario === "Socio"){
        header("Location: ../index.php");
        exit();
    }


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
    "estadosp" => "generar_reporte_estado",
    "home" => "../index"
);
include "../dao/daoPrestamo.php";
include "../pages/menu/menu.php";
$codigos = obtenerCodigosClientes();

        $lista = listarPrestamosMora();
?>
    <hr class="m-0">
    <div class="container-fluid p-4">
    <h4 class="text-center font-weight-bold mb-4">Listado de Préstamos en Mora</h4>







       <br></br>

       
<th></th>

        <table id="listadoPrestamos" class="table table-striped mt-3 " style="width:100%">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Direccion</th>
                    <th>Monto</th>
                    <th>Destino</th>
                    <th>Fecha de inicio</th>
                    <th>Estado</th>
                    <th></th>
                   
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;

                foreach ($lista as $item) {
                    echo "<tr>
                    <td>$i</td>
                    <td>$item[nombre]</td>
                    <td>$item[apellido]</td>
                    <td>$item[direccion]</td>
                    <td class='" . ($item["estadoPrestamo"] == "1" ? 'text-success' : 'text-danger') . "'>$ ".number_format($item["montoPrestamo"], 2)."</td>
                    <td >$item[destino]</td>
                    <td>$item[fechaInicio]</td>
                    <td class='" . ($item["estadoPrestamo"] == "1" ? 'text-success' : 'text-danger') . "'>" . ($item["estadoPrestamo"] == "1" ? 'ACTIVO' : 'INACTIVO') . "</td>
                    <td> 
                        <div class='dropdown'>
                            <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown'>
                                <i class='fas fa-sliders-h'></i>
                            </button>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item text-primary' href='#' onclick='mostrar($item[id])' data-toggle='modal' data-target='#modalVerCuotas'>
                                    <i class='fas fa-eye'></i> Mostrar cuotas
                                </a>
                                <a class='dropdown-item text-secundary' href='#' onclick='abrirReporte($item[id])'>
                                <i class='fas fa-eye'></i> Informacion
                            </a>
                            </div>
                        </div>
                    </td>
                </tr>";
            $i++;
                }
                ?>
            </tbody>
        </table> 
        <datalist id="codigoClientes">
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
<script src="../js/prestamo/prestamoScript.js"></script>

<!-- Bootstrap core JavaScript -->
<?php include "modal/modalVerCuotas.php"?>
<?php include "modal/modalRegistroPrestamo.php"?>

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
<script>
function abrirReporte(idPrestamo) {
    window.open('../dao/fpdf/reporteprestamo.php?id=' + idPrestamo, '_blank');
}
</script>
</body>
</html>