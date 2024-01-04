<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>Listados Cuotas</title>
    
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

    <link href="../css/styleClient.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!--<link href="../js/dataTable/dataTables.bootstrap5.min.css" rel="stylesheet">-->
    <link href="../js/dataTable/data/jquery.dataTables.min.css" rel="stylesheet">

    <link href="../css/zebra/css/flat/zebra_dialog.css" rel="stylesheet">
    <script src="../js/sweetalert/sweetalert2.all.min.js"></script>
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
        "cuentas" => "listadoCuotas",
        "socios" => "listadoSocios",
        "roles" => "listadoRoles",
        "usuarios" => "listadoUsuarios",
        "tipoCuenta" => "listadoTipoCuenta",
        "tipoOperacion" => "listadoTipoOperacion",
        "tipoMovimiento" => "listadoTipoMovimiento",
        "cerrarSesion" => "cerrar",
        "amorti" => "listadoAmortPorSocio",
        "mora" => "listadoCuotaMora"
    );
    include "../pages/menu/menu.php";   
    include "../config/conexion.php";
    include "../dao/util/sqlCuotas.php";
    include "../dao/daoCuota.php";

    $codigos = obtenerCodigosPrestamos();
    ?>
    <hr class="m-0">
    <div class="container-fluid p-4 ">
        
        <!--<h4 class="text-center bold">Listado de Cuotas</h4>-->
       <div class="row">

            <input type="text"  class="col-2" id="cuota" placeholder="Código de Préstamo" list="codigoPrestamos">
            <button class="btn ml-3 bg-primary text-light" id="buscarcuota" >
              Buscar
            </button>
 </div> 


         <table id="detallePrestamo" class="table table-striped mt-3 hide" style="width:100%">
            <thead>
                <tr>
                    <th colspan="10" class="text-center">Detalle de Préstamo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Código</th>
                    <td id="codigo">ASCG1009</td>
                    <th>Socio</th>
                    <td id="nombre">Edgar Giovanni Gómez Cerón</td>
                    <th>Monto</th>
                    <td id="monto">$12,000</td>
                    <th>Destino</th>
                    <td id="tipo">Financiamiento</td>
                    <th>Plazo (Años)</th>
                    <td id="plazo">5 años</td>
                </tr>
            </tbody>
        </table> 

        <table id="listadoCuotas" class="table table-striped mt-3 hide" style="width:100%">
            <thead>
                <tr>
                    <th colspan="5" class="text-center">Lista de cuotas</th>
                </tr>
                <tr>
                    <th>Número</th>
                    <th>Monto</th>
                    <th>Fecha de vencimiento</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="cuotasCuerpo">
                
            </tbody>
        </table> 

        <datalist id="codigoPrestamos">
            <?php
            while ($row = $codigos->fetch_assoc()) {
                echo "<option>" . $row["codigo"] . "</option>";
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
<script src="../js/cuota/cuotaScript.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/imagesloaded.pkgd.min.js"></script>
<script src="../js/isotope.pkgd.min.js"></script>
<script src="../js/filter.js"></script>
<script src="../js/jquery.appear.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/jquery.fancybox.min.js"></script>
<script src="../js/zebraDialog/zebra_dialog.src.js"></script>

<?php

}
?>
</body>
</html>