<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title> Zonebiz - Business Consulting Bootstrap4 Responsive Template </title>
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
	<script src="../js/sweetalert/sweetalert2.all.min.js"></script>

</head>

<body>
	<div class="wrapper-main p-5">
		<div class="container">
			<div class="card col-10 mx-auto border ">
				<div class="row pt-4 pl-2 pr-3">
					<div class="col-4 p-0 mh-100">
						<img src="../images/index.jpeg" class="col-12 m-0 h-100 rounded">
					</div>

					<div class="col-7">
						<h4 class="text-center col-12"> Iniciar Sesión </h4>
						<form action="">
							<div class="form-group">
								<label for="username">Nombre de usuario</label>
								<input type="text" name="username" id="username" class="form-control">

								<label for="clave" class="mt-4">Contraseña</label>
								<input type="password" name="clave" id="clave" class="form-control">

								<input type="submit" value="Iniciar Sesión" id="btnIniciarSesion" class="btn btn-success active mt-4">
								<a  name="enlaceresgistrar" id="enlaceresgistrar" class="btn btn-info mt-4" href="" role="button" data-toggle="modal" data-target="#modalRegistroSocioI"/>Registrarse</a>

								<p class="mt-4">Olvidaste la Contraseña?,
									<a href="" id="enlaceRecuperar">Recuperar Contraseña</a>.</p>
							</div>

						</form>
					</div>
				</div>
				<div class="row">
					<div id="fondo">
					
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../js/imagesloaded.pkgd.min.js"></script>
	<script src="../js/isotope.pkgd.min.js"></script>
	<script src="../js/filter.js"></script>
	<script src="../js/jquery.appear.js"></script>
	<script src="../js/owl.carousel.min.js"></script>
	<script src="../js/jquery.fancybox.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/usuario/usuarioScript.js"></script>
	<?php include "modal/modalRecuperarContraEmail.php"?>
	<?php include "modal/modalCodigo.php"?>
	<?php include "modal/modalUpdateCotra.php"?>

	<?php include "modal/modalRegistroSocioI.php" ?>
</body>
<script>
        // Método para abrir el modal
        function abrirModal() {
            $("#modalEmail").modal("show");
        }

		function abrirModalRegistrar() {
		$("#modalRegistroSocioI").modal("show");
	}

        // Asignar el método al evento clic del enlace
        $(document).ready(function () {
            $("#enlaceRecuperar").click(function (e) {
                e.preventDefault(); // Evitar que el enlace lleve a otra página
                abrirModal(); // Llamar al método para abrir el modal
            });
        });
    </script>
</html>