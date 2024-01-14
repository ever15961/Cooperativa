<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Registrarse</title>
</head>

<body>

	<!--Formulario de registro de socios-->
	<div class="wrapper-main" id="formRegistroSocio">
		<div class="container-fluid">
			<div class="card col-12 mx-auto border ">
				<div class="row pt-4 pl-2 pb-4 pr-3">
					<div class="col-12">
						<!--<h4 class="text-center col-12"> Registro de Socio </h4>-->
						<form action="" method="post">
							<div class="mb-3">
								<label for="nombres" class="form-label">Nombres</label>
								<input type="text" class="form-control" name="nombres" id="nombres" aria-describedby="helpId" placeholder="" />
							</div>

							<div class="mb-3">
								<label for="apellidos" class="form-label">Apellidos</label>
								<input type="text" class="form-control" name="apellidos" id="apellidos" aria-describedby="helpId" placeholder="" />
							</div>

							<div class="mb-3">
								<label for="direccion" class="form-label">Dirección</label>
								<input type="text" class="form-control" name="direccion" id="direccion" aria-describedby="helpId" placeholder="" />
							</div>

							<div class="mb-3">
								<label for="telefono" class="form-label">Teléfono</label>
								<input type="text" class="form-control" name="telefono" id="telefono" aria-describedby="helpId" placeholder="" />
							</div>

							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="tipoIdentificacion">Tipo Identificación</label>
										<select name="tipoIdentificacion" id="tipoIdentificacion" class="form-control">
											<option value="0" disable="" selected="">Seleccione una opcion</option>
											<option value="1">DUI</option>
											<option value="2">NIT</option>
											<option value="3">Pasaporte</option>
										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="nIdentificacion">N° Identificación</label>
										<input type="text" name="nIdentificacion" id="nIdentificacion" class="form-control">
									</div>
								</div>
							</div>

							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="usuario">Usuario</label>
										<input type="text" id="usuario" name="usuario" class="form-control">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="clave" class="bmd-label-floating">Contraseña</label>
										<input type="password" class="form-control" name="clave_" id="clave_" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
										<div class="progress mt-2">
											<div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
										</div>
										<small id="passwordStrength" class="form-text text-muted"></small>
									</div>
								</div>
							</div>

							<div class="mb-3">
								<label for="email" class="form-label">Correo Electrónico</label>
								<input type="email" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="" />
							</div>



							<div class="row col-12">
								<input type="submit" value="Registrar Socio" class="btn btn-success active ml-3" id="btnRegistrarSocio"">
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
	<script>
		$(document).ready(function() {
			$('#clave_').on('input', function() {
				var password = $(this).val();
				var strength = 0;

				// Ajusta tus reglas para evaluar la fortaleza aquí
				// Puedes agregar más reglas según tus requisitos

				// Longitud mínima
				if (password.length >= 8) {
					strength += 1;
				}

				// Contiene al menos un número
				if (/\d/.test(password)) {
					strength += 1;
				}

				// Contiene al menos una letra minúscula y una letra mayúscula
				if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
					strength += 1;
				}

				// Contiene al menos un carácter especial
				if (/[$@.-]/.test(password)) {
					strength += 1;
				}

				// Actualiza la barra de colores y el mensaje según la fortaleza
				var progress = (strength / 4) * 100;
				$('#passwordStrengthBar').width(progress + '%');

				if (strength === 0) {
					$('#passwordStrength').text('Contraseña débil');
					$('#passwordStrengthBar').removeClass().addClass('progress-bar bg-danger');
				} else if (strength <= 2) {
					$('#passwordStrength').text('Contraseña moderada');
					$('#passwordStrengthBar').removeClass().addClass('progress-bar bg-warning');
				} else {
					$('#passwordStrength').text('Contraseña fuerte');
					$('#passwordStrengthBar').removeClass().addClass('progress-bar bg-success');
				}
			});
		});
	</script>

</body>

</html>