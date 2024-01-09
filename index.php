<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<script src="js/sweetalert/sweetalert2.all.min.js"></script>
<?php
$links = array(
	"movimientos" => "pages/listadoPrestamos",
	"cuentas" => "pages/listadoCuotas",
	"socios" => "pages/listadoSocios",
	"roles" => "pages/listadoRoles",
	"usuarios" => "pages/listadoUsuarios",
	"tipoCuenta" => "pages/listadoTipoCuenta",
	"tipoOperacion" => "pages/listadoTipoOperacion",
	"tipoMovimiento" => "pages/listadoTipoMovimiento",
	"cuotas" => "pages/listadoCuotas",
	"cerrarSesion" => "pages/cerrar",
	"amorti" => "pages/listadoAmortPorSocio",
	"interes" => "pages/listaInteres",
	"mora" => "pages/listadoCuotaMora"
);

if (!isset($_SESSION["user"])) { ?>
	<script>location.href = "pages/formularioInicio.php";</script>
<?php }

// Inicia la sesión

$links = "";

if ($_SESSION["rol"] == "Socio") {

	$links = array(
		"movimientos" => "pages/listadoPrestamosSocio",
		"cuotas" => "pages/listadoCuotasSocios",
		"cerrarSesion" => "pages/cerrar",
		"home" => "index"
	);
	include "pages/menu/menuSocios.php";

} else if ($_SESSION["rol"] == "Admin") {
	$links = array(
		"movimientos" => "pages/listadoPrestamos",
		"cuentas" => "pages/listadoCuotas",
		"socios" => "pages/listadoSocios",
		"roles" => "pages/listadoRoles",
		"usuarios" => "pages/listadoUsuarios",
		"tipoCuenta" => "pages/listadoTipoCuenta",
		"tipoOperacion" => "pages/listadoTipoOperacion",
		"tipoMovimiento" => "pages/listadoTipoMovimiento",
		"cerrarSesion" => "pages/cerrar",
		"amorti" => "pages/listadoAmortPorSocio",
		"mora" => "pages/listadoCuotaMora",
		"interes" => "pages/listaInteres",
		"poranio" => "pages/generar_reporte",
		"estadosp" => "pages/generar_reporte_estado",
		"home" => "index"
	);

	include "pages/menu/menu.php";
} else {
	$links = array(
		"movimientos" => "pages/listadoPrestamos",
		"cuentas" => "pages/listadoCuotas",
		"socios" => "pages/listadoSocios",
		"roles" => "pages/listadoRoles",
		"usuarios" => "pages/listadoUsuarios",
		"tipoCuenta" => "pages/listadoTipoCuenta",
		"tipoOperacion" => "pages/listadoTipoOperacion",
		"tipoMovimiento" => "pages/listadoTipoMovimiento",
		"cerrarSesion" => "pages/cerrar",
		"amorti" => "pages/listadoAmortPorSocio",
		"mora" => "pages/listadoCuotaMora",
		"interes" => "pages/listaInteres",
		"poranio" => "pages/generar_reporte",
		"estadosp" => "pages/generar_reporte_estado",
		"home" => "index"
	);
	include "pages/menu/menu.php";
}
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Gestión de cuentas bancarias</title>
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Fontawesome CSS -->
	<link href="css/all.css" rel="stylesheet">
	<!-- Owl Carousel CSS -->
	<link href="css/owl.carousel.min.css" rel="stylesheet">
	<!-- Owl Carousel CSS -->
	<link href="css/jquery.fancybox.min.css" rel="stylesheet">
	<!-- Estilos personalizados para esta plantilla -->
	<link href="css/style.css" rel="stylesheet">

	<!-- Estilos personalizados para esta plantilla -->
	<link href="css/styleClient.css" rel="stylesheet">
</head>

<body>
	<div class="wrapper-main">

		<header class="slider-main">
			<div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
					<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<!-- Slide One - Set the background image for this slide in the line below -->
					<div class="carousel-item active" style="background-image: url('images/imagen1.jpg')">
						<div class="carousel-caption d-none d-md-block">
							<h3>Bienvenido a CommerzBank</h3>
						</div>
					</div>
					<!-- Slide Two - Set the background image for this slide in the line below -->
					<div class="carousel-item" style="background-image: url('images/imagen2.jpg')">
						<div class="carousel-caption d-none d-md-block">
							<h3>CommerzBank</h3>
							<p>Tu agencia bancaria</p>
						</div>
					</div>
					<!-- Slide Three - Set the background image for this slide in the line below -->
					<div class="carousel-item" style="background-image: url('images/imagen3.jpg')">
						<div class="carousel-caption d-none d-md-block">
							<h3>CommerzBank</h3>
							<p>Servicios de calidad</p>
						</div>
					</div>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Anterior</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Siguiente</span>
				</a>
			</div>
		</header>

		<!-- Contenido de la página -->
		<div class="container">
			<!-- Sección "Acerca de" -->
			<div class="about-section">
				<h2 class="section-title">Acerca de Nosotros</h2>
				<p>
					CommerzBank es una agencia bancaria que se preocupa por ofrecer servicios financieros de calidad a sus clientes. Con una larga historia de éxito y un equipo de profesionales dedicados, estamos comprometidos a brindar soluciones bancarias eficientes y seguras.
				</p>
			</div>

			<!-- Sección "Servicios" -->
			<div class="services-section">
				<h2 class="section-title">Nuestros Servicios</h2>
				<div class="row">
					<div class="col-md-4">
						<div class="service-box">
							<i class="fas fa-hand-holding-usd"></i>
							<h3>Prestamos</h3>
							<p>Ofrecemos una variedad de opciones de préstamos para satisfacer tus necesidades financieras.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="service-box">
							<i class="fas fa-chart-line"></i>
							<h3>Intereses</h3>
							<p>Consulta las tasas de interés actuales y maximiza tus ganancias.</p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="service-box">
							<i class="fas fa-wallet"></i>
							<h3>Cuotas</h3>
							<p>Gestiona tus cuotas y realiza pagos de manera conveniente.</p>
						</div>
					</div>
				</div>
			</div>

			<!-- Sección "Contacto" -->
			<div class="contact-section">
				<h2 class="section-title">Contáctenos</h2>
				<p>
					Estamos aquí para ayudarte. Ponte en contacto con nosotros para cualquier pregunta o inquietud.
				</p>
				<a href="pages/formularioContacto.php" class="btn btn-primary">Contacto</a>
			</div>
		</div>

		<!-- Pie de página -->
		<footer class="footer-main">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<p>&copy; 2024 UES-VA17020 - Todos los derechos reservados</p>
					</div>
					<div class="col-md-6 text-md-right">
						<ul class="list-inline social-buttons">
							<li class="list-inline-item">
								<a href="#">
									<i class="fab fa-twitter"></i>
								</a>
							</li>
							<li class="list-inline-item">
								<a href="#">
									<i class="fab fa-facebook-f"></i>
								</a>
							</li>
							<li class="list-inline-item">
								<a href="#">
									<i class="fab fa-linkedin-in"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
	</div>

	<!-- Bootstrap core JavaScript -->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Plugin JavaScript -->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Custom scripts for this template -->
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>