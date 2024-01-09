
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>Registro Socio</title>
    
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

    <script src="../js/sweetalert/sweetalert2.all.min.js"></script>

    <link href="../css/zebra/css/flat/zebra_dialog.css" rel="stylesheet">
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

    // Verifica el rol y redirige si es necesario
    if ($rolUsuario === "Empleado") {
        // Si el rol es "Empleado", redirige a otra página o realiza alguna acción
        header("Location: listadoSociosEmp.php");
        exit();
    }else  if ($rolUsuario === "Socio") {
        // Si el rol es "Empleado", redirige a otra página o realiza alguna acción
        header("Location: ../index.php");
        exit();
    }
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
    "cerrarSesion"  => "cerrar",
    "amorti" => "listadoAmortPorSocio",
    "mora" => "listadoCuotaMora",
    "interes" => "listaInteres",
    "poranio" => "generar_reporte",
    "estadosp" => "generar_reporte_estado",
    "home" => "../index"
);
include "../dao/daoSocio.php";
include "../pages/menu/menu.php";

$lista = listarSocios();
?>
    <hr class="m-0">
    <div class="container-fluid p-4 ">
        
        <h4 class="text-center bold">Listado de Socios</h4>
       <div class="row mb-3">
            <button class="btn ml-3 bg-primary text-light" data-toggle="modal" data-target="#modalRegistroSocio">Agregar Socio</button>
       </div> 
        <table id="listadoSocios" class="table table-striped mt-3 " style="width:100%">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Código</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Direccion</th>
                    <th>Identificación</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th></th>
                   
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;

                foreach ($lista as $item) {
                    echo "<tr>
                                <td>" . $i . "</td>
                                <td>" . $item[3] . "</td>
                                <td>" . $item[0] . "</td>
                                <td>" . $item[1] . "</td>
                                <td>" . $item[7] . "</td>
                                <td title='".$item[5]."' data-toggle='tooltip'>" . $item[2] . "</td>
                                <td>" . $item[4] . "</td>
                                <td>" . $item[8] . "</td>
                                
                                <td> 
                                <div class='dropdown'>
                                <button type='button' class='btn btn-primary dropdown-toggle' data-bs-toggle='dropdown'>
                                    <i class='fas fa-sliders-h'></i>
                                </button>
                                <div class='dropdown-menu'>
                                <a class='dropdown-item editar' data-toggle='modal' data-target='#modalRegistroSocio' onclick='modificar($item[6],this)'>
                                    <i class='bi bi-pen'></i>Editar
                                </a>
                                    <a class='dropdown-item text-primary' href='#' onclick=abrirReporte('$item[3]')>
                                        <i class='fas fa-eye'></i> Prestamos
                                    </a>
                                    <a class='dropdown-item text-secundary' href='#' onclick=abrirReportep('$item[3]')>
                                    <i class='fas fa-eye'></i> Prestamos pendientes
                                </a>
                                    <a class='dropdown-item text-danger' href='#'  onclick='eliminar($item[6])'>
                                        <i class='fas fa-trash-alt'></i> Eliminar
                                    </a>
                                </div>
                            </div>
                                </td>";
                                #<td><button class='editar btn  text-light bg-success' data-toggle='modal' data-target='#modalRegistroSocio'>Editar</button></td>
                                #<td><button class='eliminar btn  text-light bg-danger'>Eliminar</button></td>
                            "</tr>";
                           
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
<script src="../js/socios/sociosScript.js"></script>

<!-- Bootstrap core JavaScript -->
<?php include "modal/modalRegistroSocio.php"?>
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
<script>
    function abrirReporte($id) {
        var url = 'reportePrestamos.php?id=' + encodeURIComponent($id);
        window.open(url, '_blank');
    }
    function abrirReportep($id) {
        var url = 'reportePrestamosPendientes.php?id=' + encodeURIComponent($id);
        window.open(url, '_blank');
    }
</script>
</body>
</html>