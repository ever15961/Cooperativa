<?php session_start();?>
<!DOCTYPE html>
<html lang="en">

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
		"cerrarSesion"  => "pages/cerrar",
		"amorti"  => "pages/listadoAmortPorSocio",
		"interes" => "pages/listaInteres",
		"mora" => "pages/listadoCuotaMora"
	);

	if(!isset($_SESSION["user"])){?>
		<script>location.href="pages/formularioInicio.php";</script>
	<?php }

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
	<!-- Custom styles for this template -->
	<link href="css/style.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/styleClient.css" rel="stylesheet">
</head>
<body>
<div class="wrapper-main">
	
    <!-- Navigation -->
   <?php include "pages/menu/menu.php";?>
	
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
				<span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
            </a>
        </div>
    </header>
	
    <!-- Page Content -->
    <div class="container">        
        <!-- About Section -->
        <div class="about-main">
            <div class="row">
               <div class="col-lg-6">
                  <h2>Welcome to Zonebiz</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
				  <h5>Our smart approach</h5>
                  <ul>
                     <li>Sed at tellus eu quam posuere mattis.</li>
                     <li>Phasellus quis erat et enim laoreet posuere ac porttitor ipsum.</li>
                     <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>                     
                  </ul>
               </div>
               <div class="col-lg-6">
                  <img class="img-fluid rounded" src="images/about-img.jpg" alt="" />
               </div>
            </div>
            <!-- /.row -->
        </div>
	</div>	
	
	<div class="services-bar">
		<div class="container">
			<h1 class="py-4">Our Best Services </h1>
			<!-- Services Section -->
			<div class="row">
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-01.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Analytics </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>
					</div>
			   </div>
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-02.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Applications </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>
					</div>
			   </div>
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-03.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Business Process </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>
					</div>
			   </div>
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-04.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Consulting </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>						
					</div>
			   </div>
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-05.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Infrastructure </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>						
					</div>
			   </div>
			   <div class="col-lg-4 mb-4">
					<div class="card h-100">
						<div class="card-img">
							<img class="img-fluid" src="images/services-img-06.jpg" alt="" />
						</div>
						<div class="card-body">
							<h4 class="card-header"> Product Engineering </h4>
							<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente esse necessitatibus neque.</p>
						</div>
					</div>
			   </div>
			</div>
			<!-- /.row -->
		</div>
	</div>
		
	<div class="container">
        <!-- Portfolio Section -->
        <div class="portfolio-main">
            <h2>Our Portfolio</h2>
			<div class="col-lg-12">
				<div class="project-menu text-center">
					<button class="btn btn-primary active" data-filter="*">All</button>
					<button data-filter=".business" class="btn btn-primary">Business</button>
					<button data-filter=".travel" class="btn btn-primary">Travel</button>
					<button data-filter=".financial" class="btn btn-primary">Financial</button>
					<button data-filter=".academic" class="btn btn-primary">Academic</button>
				</div>
			</div>
            <div id="projects" class="projects-main row">
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item financial">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-01.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-01.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item business academic">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-02.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-02.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item travel">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-03.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-03.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item business">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-04.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-04.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item travel">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-05.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-05.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
               <div class="col-lg-4 col-sm-6 pro-item portfolio-item financial academic">
                  <div class="card h-100">
                     <div class="card-img">
                        <a href="images/portfolio-img-01.jpg" data-fancybox="images">
                           <img class="card-img-top" src="images/portfolio-img-01.jpg" alt="" />
                           <div class="overlay"><i class="fas fa-arrows-alt"></i></div>
                        </a>
                     </div>
                     <div class="card-body">
                        <h4 class="card-title">
                           <a href="#">Financial Sustainability</a>
                        </h4>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /.row -->
        </div>
    </div>
	
	<div class="blog-slide">
		<div class="container">
			<h2>Our Blog</h2>
			<div class="row">
				<div class="col-lg-12">
					<div id="blog-slider" class="owl-carousel">
						<div class="post-slide">
							<div class="post-header">
								<h4 class="title">
									<a href="#">Latest blog Post</a>
								</h4>
								<ul class="post-bar">
									<li><img src="images/testi_01.png" alt=""><a href="#">Williamson</a></li>
									<li><i class="fa fa-calendar"></i>02 June 2018</li>
								</ul>
							</div>
							<div class="pic">
								<img src="images/img-1.jpg" alt="">
								<ul class="post-category">
									<li><a href="#">Business</a></li>
									<li><a href="#">Financ</a></li>
								</ul>
							</div>
							<p class="post-description">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas gravida nulla eu massa efficitur, eu hendrerit ipsum efficitur. Morbi vitae velit ac.
							</p>
						</div>
		 
						<div class="post-slide">
							<div class="post-header">
								<h4 class="title">
									<a href="#">Latest blog Post</a>
								</h4>
								<ul class="post-bar">
									<li><img src="images/testi_02.png" alt=""><a href="#">Kristiana</a></li>
									<li><i class="fa fa-calendar"></i>05 June 2018</li>
								</ul>
							</div>
							<div class="pic">
								<img src="images/img-2.jpg" alt="">
								<ul class="post-category">
									<li><a href="#">Business</a></li>
									<li><a href="#">Financ</a></li>
								</ul>
							</div>
							<p class="post-description">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas gravida nulla eu massa efficitur, eu hendrerit ipsum efficitur. Morbi vitae velit ac.
							</p>
						</div>
						
						<div class="post-slide">
							<div class="post-header">
								<h4 class="title">
									<a href="#">Latest blog Post</a>
								</h4>
								<ul class="post-bar">
									<li><img src="images/testi_01.png" alt=""><a href="#">Kristiana</a></li>
									<li><i class="fa fa-calendar"></i>05 June 2018</li>
								</ul>
							</div>
							<div class="pic">
								<img src="images/img-3.jpg" alt="">
								<ul class="post-category">
									<li><a href="#">Business</a></li>
									<li><a href="#">Financ</a></li>
								</ul>
							</div>
							<p class="post-description">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas gravida nulla eu massa efficitur, eu hendrerit ipsum efficitur. Morbi vitae velit ac.
							</p>
						</div>
						
						<div class="post-slide">
							<div class="post-header">
								<h4 class="title">
									<a href="#">Latest blog Post</a>
								</h4>
								<ul class="post-bar">
									<li><img src="images/testi_02.png" alt=""><a href="#">Kristiana</a></li>
									<li><i class="fa fa-calendar"></i>05 June 2018</li>
								</ul>
							</div>
							<div class="pic">
								<img src="images/img-4.jpg" alt="">
								<ul class="post-category">
									<li><a href="#">Business</a></li>
									<li><a href="#">Financ</a></li>
								</ul>
							</div>
							<p class="post-description">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas gravida nulla eu massa efficitur, eu hendrerit ipsum efficitur. Morbi vitae velit ac.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Contact Us -->
	<div class="touch-line">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
				   <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
				</div>
				<div class="col-md-4">
				   <a class="btn btn-lg btn-secondary btn-block" href="#"> Contact Us </a>
				</div>
			</div>
		</div>
	</div>
	
    <!-- /.container -->
    <!--footer starts from here-->
    <footer class="footer">
        <div class="container bottom_border">
            <div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6 col">
					<h5 class="headin5_amrc col_white_amrc pt2">About Us</h5>
					<!--headin5_amrc-->
					<p class="mb10">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
					<ul class="footer-social">
						<li><a class="facebook hb-xs-margin" href="#"><span class="hb hb-xs spin hb-facebook"><i class="fab fa-facebook-f"></i></span></a></li>
						<li><a class="twitter hb-xs-margin" href="#"><span class="hb hb-xs spin hb-twitter"><i class="fab fa-twitter"></i></span></a></li>
						<li><a class="instagram hb-xs-margin" href="#"><span class="hb hb-xs spin hb-instagram"><i class="fab fa-instagram"></i></span></a></li>
						<li><a class="googleplus hb-xs-margin" href="#"><span class="hb hb-xs spin hb-google-plus"><i class="fab fa-google-plus-g"></i></span></a></li>
						<li><a class="dribbble hb-xs-margin" href="#"><span class="hb hb-xs spin hb-dribbble"><i class="fab fa-dribbble"></i></span></a></li>
					</ul>
				</div>	
				<div class="col-lg-3 col-md-6 col-sm-6">
					<h5 class="headin5_amrc col_white_amrc pt2">Quick links</h5>
					<!--headin5_amrc-->
					<ul class="footer_ul_amrc">
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>Default Version</a></li>
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>Boxed Version</a></li>
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>Our Team </a></li>
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>About Us</a></li>
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>Our Services</a></li>
						<li><a href="#"><i class="fas fa-long-arrow-alt-right"></i>Get In Touch</a></li>
					</ul>
					<!--footer_ul_amrc ends here-->
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 col">
					<h5 class="headin5_amrc col_white_amrc pt2">Follow us</h5>
					<!--headin5_amrc ends here-->
					<ul class="footer_ul2_amrc">
						<li>
							<a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a>
							<p>Lorem Ipsum is simply dummy...<a href="#">https://www.lipsum.com/</a></p>
						</li>
						<li>
							<a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a>
							<p>Lorem Ipsum is simply dummy...<a href="#">https://www.lipsum.com/</a></p>
						</li>
						<li>
							<a href="#"><i class="fab fa-twitter fleft padding-right"></i> </a>
							<p>Lorem Ipsum is simply dummy...<a href="#">https://www.lipsum.com/</a></p>
						</li>
					</ul>
					<!--footer_ul2_amrc ends here-->
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6 ">
					<div class="news-box">
						<h5 class="headin5_amrc col_white_amrc pt2">Newsletter</h5>
						<p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>
						<form action="#">
							<div class="input-group">
								<input class="form-control" placeholder="Search for..." type="text">
								<span class="input-group-btn">
								  <button class="btn btn-secondary" type="button">Go!</button>
								</span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
        <div class="container">
            <p class="copyright text-center">All Rights Reserved. &copy; 2018 <a href="#">Zonebiz</a> Design By : 
				<a href="https://html.design/">html design</a>
            </p>
        </div>
    </footer>
</div>
	  
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/filter.js"></script>
<script src="js/jquery.appear.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/script.js"></script>
<?php  include "pages/modal/modalRegistroSocio.php"?>
<script src="js/formRegistroSocio.js"></script>

</body>
</html>