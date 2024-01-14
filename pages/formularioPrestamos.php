<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Registro de Préstamos</title>
</head>
<body>
<script src="../js/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>

<?php
if (isset($_SESSION["user"])) {
        // Accede al valor de la variable de sesión "user"
	$nombreUsuario = $_SESSION["user"];
	$rolUsuario = $_SESSION["rol"]; // Debes tener una función que obtenga el rol del usuario

	if ($rolUsuario === "Socio") {
		header("Location: ../index.php");
		exit();
	}
	?>

	<!--Formulario de registro de socios-->
	<div class="wrapper-main" id="formRegistroPrestamos">
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
										<label for="monto">Monto</label>
										<input type="number" name="monto" id="monto" class="form-control">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="plazo">Plazo (Años)</label>
										<input type="number" name="plazo" id="plazo" class="form-control">
									</div>
								</div>
							</div>

							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="plazocuota">Plazo de pago cuota</label>
										<select name="plazocuota" id="plazocuota" class="form-control">
											<option value="1">Mensual</option>
											<option value="2">Trimestral</option>
											<option value="3">Semestral</option>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label for="socio">Socio</label>
										<select name="socio" id="socio" class="form-control">
											<?php
										include "../config/conexion.php";

										$sql = "SELECT * FROM socio order by nombre, apellido";
										$stmt = $conexion->prepare($sql);
										$stmt->execute();
										$result = $stmt->get_result();
										while ($fila = $result->fetch_assoc()) {
											if ($fila['id'] == $socio) {
												echo " <option value=" . $fila['id'] . " selected>" . $fila['nombre'] . " " . $fila['apellido'] . "</option>";
											} else {
												echo " <option value=" . $fila['id'] . ">" . $fila['nombre'] . " " . $fila['apellido'] . "</option>";
											}

										}
										?>
										</select>
									</div>
								</div>

							</div>

							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="destino">Destino</label>
										<select name="destino" id="destino" class="form-control"
											onchange="actualizarTasaInteres()">
											<option value=0>Seleccione uno</option>
											<?php
										include "../config/conexion.php";

										$sql = "SELECT * FROM interes ORDER BY destino";
										$stmt = $conexion->prepare($sql);
										$stmt->execute();
										$result = $stmt->get_result();
										while ($fila = $result->fetch_assoc()) {
											echo "<option value=" . $fila['id'] . " data-tasainteres=" . $fila['tasaInteres'] . ">" . $fila['destino'] . "</option>";
										}
										?>
										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="interes">Tasa de interes</label>
										<input type="number" name="interes" id="interes" class="form-control"
											value="<?php echo $interes; ?>">
									</div>
								</div>

							</div>
							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="fInicio">Fecha del prestamo</label>
										<input type="date" name="fInicio" id="fInicio" class="form-control">
									</div>
								</div>

							</div>


							<div class="row col-12">
								<input type="submit" value="Registrar Préstamos" class="btn btn-success active ml-3"
									id="btnRegistrarPrestamo">
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
<script>
	function actualizarTasaInteres() {
		// Obtener el valor seleccionado en el campo de destino
		var destinoSelect = document.getElementById("destino");
		var selectedOption = destinoSelect.options[destinoSelect.selectedIndex];

		// Obtener el valor de la tasa de interés asociado a la opción seleccionada
		var tasaInteres = selectedOption.getAttribute("data-tasainteres");

		// Actualizar el valor del campo de tasa de interés con el valor asociado
		document.getElementById("interes").value = tasaInteres;
	}
</script>

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
} ?>
</html>