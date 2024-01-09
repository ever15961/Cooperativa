<?php $path = isset($url) ? $url : "";

// Verifica si la variable de sesión "user" está configurada
if (isset($_SESSION["user"])) {
    // Accede al valor de la variable de sesión "user"
    $nombreUsuario = $_SESSION["user"];

}
	?>
	<script src="js/sweetalert/sweetalert2.all.min.js"></script>
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
							<li><i class="fas fa-phone fa-rotate-90"></i> +01 2393-4566</li>
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
				<a class="navbar-brand" href="<?php echo $links["home"] . ".php"; ?>">
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
							<a class="nav-link active" href="<?php echo $links["home"] . ".php"; ?>">Inicio</a>
						</li>
			
						<!--Transacciones-->	
						<li class="nav-item dropdown  itemsList mt-2" id="itemDropDown">
							<a class="itemsLine nav-link" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="https://img.icons8.com/color/48/000000/contract.png" class="itemsLine"/>Préstamos
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["movimientos"].".php";?>">
									<img src="https://img.icons8.com/color/48/bank-building.png" class="itemsLine"/>Ver Préstamos
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
							<img src="https://img.icons8.com/color/48/000000/coins.png" class="itemsLine"/>Cuotas
								<i class="fas fa-sort-down itemsLine icono"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
								<a class="dropdown-item" href="<?php echo $links["cuotas"].".php";?>">
									<img src="https://img.icons8.com/color/48/000000/check.png" class="itemsLine"/>Ver Cuotas
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
		
							<a class="dropdown-item" href="#" onclick="confirmarCerrarSesion()">
								<img src="<?php echo $path; ?>images/cerrarSesion.png" class="itemsLine" />Cerrar Sesión
							</a>

							
							<script>
								function confirmarCerrarSesion() {
									Swal.fire({
										title: '¿Estás seguro?',
										text: 'Cerrar sesión',
										icon: 'question',
										showCancelButton: true,
										confirmButtonColor: '#3085d6',
										cancelButtonColor: '#d33',
										confirmButtonText: 'Sí, cerrar sesión'
									}).then((result) => {
										if (result.isConfirmed) {
											// Aquí puedes redirigir a la página de cerrar sesión
											window.location.href = "<?php echo $links["cerrarSesion"]."formularioInicio.php"; ?>";
										}
									});
								}
							</script>
							</div>
						</li>
					
					</ul>
					</div>
				</div>
        	</div>
    </nav>