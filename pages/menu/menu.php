<?php $path = isset($url) ? $url : "";

// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];

}
	?>
<!-- Top Bar -->
<div class="top-bar">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="social-media">
						<ul>
							<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
							<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
							<li><a href="#"><i class="fab fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="contact-details">
						<ul>
							<li><i class="fas fa-phone fa-rotate-90"></i> +01 899 286 777</li>
							<li><i class="fas fa-map-marker-alt"></i> San Vicente</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-light top-nav m-0">
        <div class="container m-0 col-12">

			<div class="col-3">
				<a class="navbar-brand" href="<?echo $path;?>">
					<img src="<?php echo $path; ?>images/logoDef2.png" alt="logo" />
				</a>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
					<span class="fas fa-bars"></span>
				</button>
				
			</div>
            
			<div class="col-9">
            	<div class="collapse navbar-collapse pt-1 pb-1" id="navbarResponsive">
					<ul class="navbar-nav ml-auto">

						<!--Home-->	
						<li class="nav-item itemsList mt-2">
							<a class="nav-link active" href="index.html">Home</a>
						</li>
			
						<!--Transacciones-->	
						<li class="nav-item dropdown  itemsList mt-2" id="itemDropDown">
							<a class="itemsLine nav-link" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="<?php echo $path; ?>images/transaccion.png" class="itemsLine"/>Préstamos
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["movimientos"].".php";?>">
									<img src="<?php echo $path; ?>images/verMovimientos.png" class="itemsLine"/>Ver Préstamos
								</a>
								<a class="dropdown-item" href="<?php echo $links["mora"].".php";?>">
									<img src="<?php echo $path; ?>images/verMovimientos.png" class="itemsLine"/>Préstamos en mora
								</a>
								<a class="dropdown-item" href="<?php echo $links["poranio"].".php";?>">
									<img src="<?php echo $path; ?>images/verMovimientos.png" class="itemsLine"/>Préstamos por años
								</a>

								<a class="dropdown-item" href="<?php echo $links["estadosp"].".php";?>">
									<img src="<?php echo $path; ?>images/verMovimientos.png" class="itemsLine"/>Estado de prestamos
								</a>
								<!--<a class="dropdown-item" href="404.html">
									<img src="<?php echo $path; ?>images/addMovimientos.png" class="itemsLine"/>
									Agregar Movimiento
								</a>-->
							</div>
						</li>

						<!--cuentas-->	
		
						<li class="nav-item dropdown  itemsList mt-2" id="itemDropDown">
							<a class="itemsLine nav-link" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="<?php echo $path; ?>images/cuenta.png" class="itemsLine"/>Cuotas
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["cuentas"].".php";?>">
									<img src="<?php echo $path; ?>images/verCuentas.png" class="itemsLine"/>Ver Cuotas
								</a>
								<a class="dropdown-item" href="<?php echo $links["amorti"].".php";?>">
									<img src="<?php echo $path; ?>images/tipoMovimiento.png" class="itemsLine"/>Amortizacion
								</a>
							</div>
						</li>

						<!--Socios-->	
						<li class="nav-item dropdown  itemsList mt-2" id="itemDropDown">
							<a class="itemsLine nav-link" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="<?php echo $path; ?>images/socios.png" class="itemsLine"/>Socios
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["socios"].".php";?>">
									<img src="<?php echo $path; ?>images/verSocios.png" class="itemsLine"/>Ver Socios
								</a>
								<!--<a class="dropdown-item" data-toggle="modal" data-target="#modalRegistroSocio">
									<img src="<?php echo $path; ?>images/addSocio.png" class="itemsLine" />
									Agregar Socio
								</a>-->
							</div>
						</li>


						<!--Mantenimiento-->	
						<li class="nav-item dropdown  itemsList mt-2" id="itemDropDown">
							<a class="itemsLine nav-link" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="<?php echo $path; ?>images/mantenimiento.png" class="itemsLine img"/>Mantenimiento 
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["roles"].".php";?>">
									<img src="<?php echo $path; ?>images/rol.png" class="itemsLine"/>
								 	Roles
								</a>
								<a class="dropdown-item" href="<?php echo $links["usuarios"].".php";?>">
									<img src="<?php echo $path; ?>images/usuarios.png" class="itemsLine"/>Usuarios
								</a>
								<a class="dropdown-item" href="<?php echo $links["interes"].".php";?>">
									<img src="<?php echo $path; ?>images/tipoCuenta.png" class="itemsLine"/>Interes
								</a>
								<a class="dropdown-item" href="<?php echo $links["tipoOperacion"].".php";?>">
									<img src="<?php echo $path; ?>images/tipoOperacion.png" class="itemsLine"/>Tipo Operacion
								</a>
								<a class="dropdown-item" href="<?php echo $links["tipoMovimiento"].".php";?>">
									<img src="<?php echo $path; ?>images/tipoMovimiento.png" class="itemsLine"/>Tipo Movimiento
								</a>
							</div>
						</li>

					
					<!--Usuario-->	
						<li class="nav-item dropdown itemsList">
							<a class="itemsLine nav-link nombreUsuario active" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<img src="<?php echo $path; ?>images/user.png" class="itemsLine imgUser"/><?php echo $nombreUsuario; ?>
								<i class="fas fa-sort-down itemsLine icono usuario"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="faq.html">
									<img src="<?php echo $path; ?>images/editarUser.png" class="itemsLine"/>Editar Información
								</a>
								
								<a class="dropdown-item" href="<?php echo $links["cerrarSesion"]."formularioInicio.php"?>">
									<img src="<?php echo $path; ?>images/cerrarSesion.png" class="itemsLine"/>Cerrar Sesión
								</a>
							</div>
						</li>
					

					</ul>
					</div>
				</div>
        	</div>
    </nav>