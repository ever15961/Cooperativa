<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    <title>Registro Usuario</title>
    
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
</head>


<body>
<?php
// Inicia la sesión
session_start();

// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    
    $nombreUsuario = $_SESSION["user"];
    $rolUsuario = $_SESSION["rol"]; 

    if ($rolUsuario === "Empleado") {
       
        header("Location: ../index.php");
        exit();
    }else if ($rolUsuario === "Socio") {
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
include "../dao/daoUsuario.php";
include "../pages/menu/menu.php";

$lista = listarUsuarios();

?>

    <hr class="m-0">
    <div class="container-fluid p-4 ">
        
        <h4 class="text-center bold">Listado de Usuarios</h4>
       <div class="row mb-3">
            <button class="ingresar btn ml-3 bg-primary text-light" data-toggle="modal" data-target="#modalRegistroUsuario">Agregar Usuarios</button>
       </div> 
        <table id="listadoUsuarios" class="table table-striped mt-3 " style="width:100%">
            <thead>
            <tr>
                    <th>N°</th>
                    <th>Usuario</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Identificación</th>
                    <th>Rol</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;

                foreach ($lista as $item) {
                    $colorFondo = ($item[5] == "1") ? 'bg-primary' : 'bg-success';
                    $colorTexto = 'text-white';
                
                    $colorFondo = ($item[5] == "1") ? 'bg-info' : 'bg-success';
                    $colorTexto = 'text-white';
                
                    echo "<tr>
                    <td>" . $i . "</td>
                    <td>" . $item[0] . "</td>
                    <td>" . $item[1] . "</td>  
                    <td>" . $item[2] . "</td>           
                    <td title='".$item[4]."' data-toggle='tooltip'>" . $item[3] . "</td>
                    <td class='text-center'>
                        <span class='rounded-pill " . $colorFondo . " " . $colorTexto . "' style='padding: 0.2rem 0.5rem;'>
                            " . ($item[5]=="1" ? '<i class="fas fa-crown"></i> Administrador' : '<i class="fas fa-user"></i> Empleado') . "
                        </span>
                    </td> 
                    <td> 
                        <div class='dropdown'>
                            <button type='button' class='btn btn-primary dropdown-toggle' data-toggle='dropdown'>
                                <i class='bi bi-sliders'></i>
                            </button>
                            <div class='dropdown-menu'>
                                <a class='dropdown-item editar' data-toggle='modal' data-target='#modalRegistroUsuario' onclick='modificar($item[6],this)'>
                                    <i class='bi bi-pen'></i> Editar
                                </a>
                                <a class='dropdown-item eliminar' href='#' onclick='eliminar($item[6])'>
                                    <i class='bi bi-trash3-fill'></i> Eliminar
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
<script src="../js/usuarios/usuariosScript.js"></script>

<!-- Bootstrap core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/imagesloaded.pkgd.min.js"></script>
<script src="../js/isotope.pkgd.min.js"></script>
<script src="../js/filter.js"></script>
<script src="../js/jquery.appear.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/jquery.fancybox.min.js"></script>
<script src="../js/zebraDialog/zebra_dialog.src.js"></script>

<?php include "modal/modalRegistroUsuario.php"?>
<?php
}else{
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