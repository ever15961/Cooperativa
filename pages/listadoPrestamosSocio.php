<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>Listados Préstamos</title>
  
	<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/all.css" rel="stylesheet">
	<link href="../css/owl.carousel.min.css" rel="stylesheet">
	<link href="../css/jquery.fancybox.min.css" rel="stylesheet">
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
session_start();

if (isset($_SESSION["user"])) {
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; 
    if ($rolUsuario === "Empleado") {
        // Si el rol es "Empleado", redirige a otra página o realiza alguna acción
        header("Location: ../index.php");
        exit();
    }else  if ($rolUsuario === "Admin") {
        header("Location: ../index.php");
        exit();
    }

    $url = "../";
    $links = array(
        "movimientos" => "listadoPrestamosSocio",
        "cerrarSesion" => "cerrar",
        "cuotas" => "listadoCuotasSocios",
        "home" => "../index"
    );
    include "../dao/daoPrestamo.php";
    include "../pages/menu/menuSocios.php";



    $lista = listarPrestamosSocio();

    $nombre = "";
    $apellido = "";
    $direccion = "";
    $ocultar="";

    if (count($lista) == 0) {
        $ocultar = "hide";
    } else {
        $nombre = $lista[0][0];
        $apellido = $lista[0][1];
        $direccion = $lista[0][2];
    }

    ?>
    <hr class="m-0">
    <div class="container-fluid p-4 ">
        
       <!--<div class="row">
            <button class="btn ml-3 mt 3 bg-warning text-light float-right" data-toggle="modal" data-target="#modalRegistroPrestamo">Agregar Préstamo</button>
       </div> -->

       
       <table id="listadoDetalleSocio" class="table table-striped mt-3 <?php echo $ocultar ?>" style="width:100%">
            <thead>
                <tr><th colspan="3" class="text-center">Detalle de Socio</th></tr>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $nombre ?></td>
                    <td><?php echo $apellido ?></td>
                    <td><?php echo $direccion ?></th>
                </tr>
            </tbody>
        </table>
                
        <table id="listadoPrestamos" class="table table-striped mt-3 <?php echo $ocultar ?>" style="width:100%">
            <thead>
                <tr><th colspan="7" class="text-center">Listado de préstamos</th></tr>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
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
                    <td>".$item[8]."</td>
                    <td class='" . ($item[6] == "1" ? 'text-success' : 'text-danger') . "'>$ " . number_format($item[3], 2) . "</td>
                    <td class=" . $item[4] . ">" .
                        $item[4] .
                        "</td>
                    <td>$item[5]</td>
                    <td>" . ($item[6] == "1" ? 'ACTIVO' : 'INACTIVO') . "</td>
                    <td> 
                        <div class='dropdown'>
                            <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown'>
                                <i class='fas fa-sliders-h'></i>
                            </button>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item text-primary' href='#' onclick='mostrar($item[7])' data-toggle='modal' data-target='#modalVerCuotas'>
                                    <i class='fas fa-eye'></i> Mostrar
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
    </div>

<div class="alert alert-primary col-3 float-right hide" id="alertaMensaje">
    <button class="close" data-dismiss="alert">&times</button>
    <strong>Registro Guardado!</strong>
</div>
 
<script src="../vendor/jquery/jquery.min.js"></script>

<script src="../js/dataTable/jquery.dataTables.min.js"></script>
<script src="../js/prestamo/prestamoScriptSocio.js"></script>

<!-- Bootstrap core JavaScript -->
<?php include "modal/modalVerCuotas.php" ?>

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