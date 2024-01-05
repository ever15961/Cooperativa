<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Registro Interes</title>
</head>

<body>

	<!--Formulario de registro de socios-->
	<div class="wrapper-main" id="formRegistroSocio">
		<div class="container-fluid">
			<div class="card col-12 mx-auto border ">
				<div class="row pt-4 pl-2 pb-4 pr-3">
					<div class="col-4 p-0 mh-100">
						<img src="<?php echo $path; ?>images/socios3.png" class="col-10 m-0 h-75 rounded">
					</div>

					<div class="col-8">
						<!--<h4 class="text-center col-12"> Registro de Socio </h4>-->
						<form action="" method="post">
							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="destino">Destino</label>
										<input type="text" name="destino" id="destino" class="form-control">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="interes">Tasa de Interes</label>
										<input type="number" name="interes" id="interes" class="form-control">
									</div>
								</div>
							</div>



							<div class="row col-12">
								<input type="submit" value="Registrar Interes" class="btn btn-success active ml-3"
									id="btnRegistrarInteres">
							</div>

						</form>
					</div>
				</div>
				<!--<div class="row">
					<div id="fondo">

					</div>
				</div>-->
			</div>
		</div>
	</div>
</body>

</html>