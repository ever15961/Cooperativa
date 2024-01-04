<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Mostrar Cuotas</title>
</head>

<body>
    <hr class="m-0">
    <div class="container-fluid p-4 ">
        
        <h4 class="text-center bold">Listado de Cuotas</h4>
        <table id="listadoCuota" class="table table-striped mt-3 " style="width:100%">
            <thead>
            <tr>
                    <th>N°</th>
                    <th>Monto</th>
                    <th>Fecha de vencimiento</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="mitabla">
              
            </tbody>
        </table> 
    </div>

<div class="alert alert-primary col-3 float-right hide" id="alertaMensaje">
    <button class="close" data-dismiss="alert">&times</button>
    <strong>Registro Guardado!</strong>
</div>
 

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>