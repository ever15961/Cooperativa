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

	<!--Formulario de registro de socios-->
	<div class="wrapper-main" id="formRegistroPrestamos">
		<div class="container-fluid">
			<div class="card col-12 mx-auto border ">
				<div class="row pt-4 pl-2 pb-4 pr-3">
					<div class="col-4 p-0 mh-100">
						<img src="<?php echo $path;?>images/socios3.png" class="col-10 m-0 h-75 rounded">
					</div>

					<div class="col-8">
						<!--<h4 class="text-center col-12"> Registro de Socio </h4>-->
						<form action="" method="post">
							<div class="row col-12">
								<div class="col-6">
									<div class="form-group">
										<label for="monto">Monto</label>
										<input type="text" name="monto" id="monto" class="form-control">
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
										<label for="direccion">Plazo de pago cuota</label>
										<select name="plazocuota" id="plazocuota" class="form-control">
											<option value="1">Mensual</option>
											<option value="2">Trimestral</option>
											<option value="3">Semestral</option>
										</select>
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label for="direccion">Socio</label>
										<select name="socio" id="socio" class="form-control">
										<?php
                                                                include "../config/conexion.php";

                                                                $sql = "SELECT * FROM socio order by nombre, apellido";
                                                                $stmt = $conexion->prepare($sql);
                                                                $stmt->execute();
                                                                $result = $stmt->get_result();
                                                                while ($fila = $result->fetch_assoc()) {
                                                                        if($fila['id'] == $socio){
                                                                            echo " <option value=".$fila['id']." selected>".$fila['nombre']." ".$fila['apellido']."</option>";
                                                                        }else{
                                                                            echo " <option value=".$fila['id'].">".$fila['nombre']." ".$fila['apellido']."</option>";
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
										<select name="destino" id="destino" class="form-control">
											<option value="1">Cultivo</option>
											<option value="2">Personal</option>
											<option value="3">Financiamiento</option>
										</select>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="interes">Tasa de interes</label>
										<input type="number" name="interes" id="interes" class="form-control">
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
									<input type="submit" value="Registrar Préstamos" class="btn btn-success active ml-3" id="btnRegistrarPrestamo">				
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