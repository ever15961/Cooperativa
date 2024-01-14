<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Registro Usuario</title>
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


	<!--Formulario de registro de usuarios-->
	<div class="wrapper-main" id="formRegistroUsuario">
		<div class="container-fluid">
			<div class="card col-12 mx-auto border ">
				<div class="row pt-4 pl-2 pb-4 pr-3">

					<div class="col-12">
						<!--<h4 class="text-center col-12"> Registro de Usuarios </h4>-->
						<form action="" method="post">
                        <fieldset>
			<legend><i class="far fa-address-card" ></i> &nbsp; Información personal</legend>
			
							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="nombres">Nombres</label>
										<input type="text" name="nombres" id="nombres" class="form-control" required="">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="apellidos">Apellidos</label>
										<input type="text" name="apellidos" id="apellidos" class="form-control" required="">
									</div>
								</div>
							</div>


							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="tipoIdentificacion">Tipo Identificación</label>
										<select name="tipoIdentificacion" id="tipoIdentificacion" class="form-control" required="">
										<option value="0" disable="" selected="">Seleccione una opcion</option>	
										<option value="1">DUI</option>
											<option value="2">NIT</option>
										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="nIdentificacion">N° Identificación</label>
										<input type="text" name="nIdentificacion" id="nIdentificacion" class="form-control" required="">
									</div>
								</div>
							</div>
</fieldset>
        
<fieldset id="infoCuen">                                    
			<legend>
            <br>
            <i class="fas fa-user-lock"></i> &nbsp; Información de la cuenta</legend>
			<div class="group-form">
				<div class="row col-12">
					<div class="col-6">
						<div class="form-group">
							<label for="usuario" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{1,35}" class="form-control" name="usuario" id="usuario" maxlength="35" required="">
						</div>
					</div>

					<div class="col-6">
    <div class="form-group">
        <label for="clave" class="bmd-label-floating">Contraseña</label>
        <input type="password" class="form-control" name="clave" id="clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
        <div class="progress mt-2">
            <div id="passwordStrengthBar1" class="progress-bar" role="progressbar" style="width: 0%;"></div>
        </div>
        <small id="passwordStrength1" class="form-text text-muted"></small>
    </div>
</div>
					<div class="col-6">
						<div class="form-group">
							<label for="clave2" class="bmd-label-floating">Repetir contraseña</label>
							<input type="password" class="form-control" name="clave2" id="clave2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required="" >
						</div>
					</div>
				</div>
			</div>
		</fieldset >
        <fieldset id="nuevaCon">
			<legend style="margin-top: 40px;">
            <br>
            <i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
			<p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
			<div class="container-fluid">
				<div class="row">
				<div class="col-12 col-md-6">
    <div class="form-group">
        <label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
        <input type="password" class="form-control" name="usuario_clave_nueva_1" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
        <div class="progress mt-2">
            <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
        </div>
        <small id="passwordStrength" class="form-text text-muted"></small>
    </div>
</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
							<input type="password" class="form-control" name="usuario_clave_nueva_2" id="usuario_clave_nueva_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
						</div>
					</div>
				</div>
			</div>
		</fieldset>
            <fieldset>
            <legend >
            <br>    
            <i class="fas fa-medal" ></i> &nbsp; Nivel de privilegio</legend>
			<div class="group-form">
				<div class="row col-12">
					<div class="col-12">
						<p><span class="badge badge-info">Administrador</span> Permisos para registrar, actualizar y eliminar</p>
						<p><span class="badge badge-success">Empleado</span> Permisos para registrar y actualizar</p>
						<div class="form-group">
							<select class="form-control" name="usuario_privilegio" id="usuario_privilegio" required="">
								<option value="0" disabled="" selected="">Seleccione una opción</option>
								<option value="1">Administrador</option>
								<option value="2">Empleado</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
								<div class="row col-12">
									<input type="submit" value="Registrar Usuario" class="btn btn-success active ml-3" id="btnRegistrarUsuario">				
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
    $(document).ready(function () {
        $('#usuario_clave_nueva_1').on('input', function () {
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
<script>
    $(document).ready(function () {
        $('#clave').on('input', function () {
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
            $('#passwordStrengthBar1').width(progress + '%');

            if (strength === 0) {
                $('#passwordStrength1').text('Contraseña débil');
                $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-danger');
            } else if (strength <= 2) {
                $('#passwordStrength1').text('Contraseña moderada');
                $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-warning');
            } else {
                $('#passwordStrength1').text('Contraseña fuerte');
                $('#passwordStrengthBar1').removeClass().addClass('progress-bar bg-success');
            }
        });
    });
</script>
</body>
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

</html>