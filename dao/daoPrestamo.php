<?php 

include "util/sqlPrestamo.php";
//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            registrarPrestamo();
        break;

        case "eliminar":
                eliminarPrestamo();
            break;

            case "mostrar":
                mostrar();
            break;

        case "pagar":
            pagar();
            break;    

        default :
            break;
    }
}
function obtenerPrestamosPorSocios($data) {
    include "../config/conexion.php";

    $stm = $conexion->prepare(SELECCIONAR_PRESTAMOS_AMORTIZACION);
    $stm->bind_param("s", $data);

    if($stm->execute()) {
        $result = $stm->get_result();

        return $result->fetch_all();
    }
}
function pagar() {
    include "../config/conexion.php";

    $id = $_POST["id"];
    $idPrestamo = $_POST["idPrestamo"];

    // Verificar la contraseña del usuario
    $stm = $conexion->prepare(PAGAR_CUOTA);
    $stm->bind_param("i", $id);

    if (!$stm->execute()) {
        // Error al obtener el socio, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Error al pagar la cuota"]);
    } else {
        $listaCuota = mostrarcuotasp($idPrestamo);

        // Obtener el número total de cuotas y cuotas pagadas
        $totalCuotas = obtenerTotalCuotas($idPrestamo);
        $cuotasPagadas = obtenerCuotasPagadas($idPrestamo);

        // Si todas las cuotas han sido pagadas, actualizar el estado del préstamo
        if ($cuotasPagadas == $totalCuotas) {
            actualizarEstadoPrestamo($idPrestamo);
        }

        // Construye un array con el ID
        $data = array('id' => $listaCuota);
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Cuota pagada con éxito"]);
    }
}

// Función para obtener el número total de cuotas para un préstamo
function obtenerTotalCuotas($idPrestamo) {
    include "../config/conexion.php";

    $stm = $conexion->prepare(OBTENER_TOTAL_CUOTAS);
    $stm->bind_param("i", $idPrestamo);

    if ($stm->execute()) {
        $result = $stm->get_result();
        $row = $result->fetch_assoc();
        return $row['total_cuotas'];
    }

    return 0;
}

// Función para obtener el número de cuotas pagadas para un préstamo
function obtenerCuotasPagadas($idPrestamo) {
    include "../config/conexion.php";

    $stm = $conexion->prepare(OBTENER_CUOTAS_PAGADAS);
    $stm->bind_param("i", $idPrestamo);

    if ($stm->execute()) {
        $result = $stm->get_result();
        $row = $result->fetch_assoc();
        return $row['cuotas_pagadas'];
    }

    return 0;
}

// Función para actualizar el estado del préstamo
function actualizarEstadoPrestamo($idPrestamo) {
    include "../config/conexion.php";

    $stm = $conexion->prepare(ACTUALIZAR_ESTADO_PRESTAMO);
    $stm->bind_param("i", $idPrestamo);

    $stm->execute();
}

function mostrar(){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Verifica si "posicion" está presente en la solicitud
        if (isset($_POST["posicion"])) {
            // Obtén el valor de "posicion"
            $id = $_POST["posicion"];
            $listaCuota=mostrarcuotasp($id);
            // Construye un array con el ID
            $data = array('id' => $listaCuota);
    
            // Convierte el array a formato JSON y lo imprime
            echo json_encode($data);
        } else {
            // Si "posicion" no está presente en la solicitud, emite un mensaje de error
            echo json_encode(array('error' => 'Posicion no proporcionada'));
        }
    } else {
        // Si la solicitud no es POST, emite un mensaje de error
        echo json_encode(array('error' => 'Se esperaba una solicitud POST'));
    }
   }
function registrarPrestamo(){
    include "../config/conexion.php";
    
    $data=obtenerParametros();

    // Generar un código único para el préstamo
    $codigoUnico = obtenerCodigoPrestamo($data["socio"],$data["fechaInicio"],$data["monto"]);
    $stm = $conexion->prepare(GUARDAR_PRESTAMOS);
    $stm->bind_param("sdisiiii",$codigoUnico, $data["monto"], $data["destino"],$data["fechaInicio"],$data["socio"],$data["plazo_anio"],$data["plazo_cuota"],$data["tasaInteres"]);

    if($stm->execute()){
        $stm = $conexion->query(SELECCIONAR_ULTIMO_PRESTAMO);
        if($stm){
            $data["id"] = $stm->fetch_row()[0];
        }
    }

    calcularYGuardarCuotasConFechas($data["id"],$data["monto"],$data["tasaInteres"],$data["plazo_anio"],$data["plazo_cuota"],$data["fechaInicio"]);


}

function obtenerCodigoPrestamo($id,$fecha, $monto)
{
    $completo = $id.$fecha . $monto;
    $completo = str_replace(" ", "", $completo);

    $iteracion = rand(1, 6);

    $codigo = "";

    for ($i = 1; $i <= 6; $i++) {
        if ($i == $iteracion) {
            $n = rand(0, 9);
            $codigo .= $n;

        } else {
            $n = rand(0, strlen($fecha));
            $codigo .= $completo[$n];
            $completo[$n] = " ";
            $completo = str_replace(" ","",$completo);
        }
    }
    return $codigo;
}
function listarCuotas(){
    include "../config/conexion.php";
    $stm = $conexion->query(TODS_CUOTAS);
    if($stm){
        return $stm->fetch_all();
    }
    return null;
}

function mostrarcuotasp($id){
    include "../config/conexion.php";
    
    // Utiliza la declaración preparada para prevenir inyecciones SQL
    $sql = TODS_CUOTAS_PRES;
    $stmt = $conexion->prepare($sql);

    // Verifica si la preparación fue exitosa
    if ($stmt) {
        // Vincula el parámetro usando bind_param
        $stmt->bind_param("i", $id);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado
        $result = $stmt->get_result();

        // Obtiene todas las filas como un array asociativo
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Cierra la declaración
        $stmt->close();

        // Devuelve los resultados
        return $rows;
    } else {
        // Manejo de error si la preparación falla
        return null;
    }
}

function calcularYGuardarCuotasConFechas($idPrestamo,$montoPrestamo, $tasaInteresAnual, $plazoAnios, $frecuenciaPago, $fechaInicio) {
    // ... (código para la conexión a la base de datos)
    include "../config/conexion.php";
try{

    // Convertir la fecha de inicio a objeto DateTime
    $fechaVencimiento = new DateTime($fechaInicio);

    // Convertir el plazo de años a meses
    $plazoMeses = $plazoAnios * 12;

    // Calcular la tasa de interés mensual
    $tasaInteresMensual = $tasaInteresAnual / 12 / 100;
if($frecuenciaPago==1){
    $frecuencia="mensual";
    $fechaVencimiento->add(new DateInterval('P1M'));
}else if($frecuenciaPago==2){
$frecuencia="trimestral";
$fechaVencimiento->add(new DateInterval('P3M'));
}else{
    $frecuencia="semestral";
    $fechaVencimiento->add(new DateInterval('P6M'));
}


// Calcular la cuota mensual sin ajustes
$cuotaMensual = ($montoPrestamo * $tasaInteresMensual) / (1 - pow(1 + $tasaInteresMensual, -$plazoMeses));


// Ajustar la cuota según la frecuencia de pago
if ($frecuencia === "trimestral") {
    $cuotaMensual = $cuotaMensual * 3;  // Multiplicar la cuota por 3 para ajustar a pagos trimestrales
} elseif ($frecuencia === "semestral") {
    $cuotaMensual = $cuotaMensual * 6;  // Multiplicar la cuota por 6 para ajustar a pagos semestrales
}

    // Preparar la consulta para insertar cuotas

    $stmtInsertarCuota = $conexion->prepare(GUARDAR_CUOTAS);
    $stmtInsertarCuota->bind_param("iidsddd", $idPrestamo, $numeroCuota, $cuota,$fechaVencimientoStr, $interes, $principal, $saldoPendiente);
    $saldoPendiente= $montoPrestamo;
    // Calcular y guardar las cuotas mensuales
    for ($i = 1; $i <= $plazoMeses; $i++) {
    // Calcular el interés para este período
    if ($frecuencia === "mensual" || ($frecuencia === "trimestral" && $i % 3 === 0) || ($frecuencia === "semestral" && $i % 6 === 0)) {
        $interes = $saldoPendiente * $tasaInteresMensual;

        // Ajustar el interés si es trimestral
        if ($frecuencia === "trimestral" && $i % 3 === 0) {
            $interes *= 3;  // Multiplicar el interés por 3 para ajustar a pagos trimestrales
        } elseif ($frecuencia === "semestral" && $i % 6 === 0) {
            $interes *= 6;  // Multiplicar el interés por 6 para ajustar a pagos semestrales
        }

        // Calcular el principal para este período
        $principal = $cuotaMensual - $interes;

        // Ajustar el principal si es la última cuota
        if ($i == $plazoMeses) {
            $principal = max($saldoPendiente, 0); // Asegurarse de que el principal no sea negativo
        }

        // Actualizar el saldo pendiente
        $saldoPendiente -= $principal;

        // Almacenar la cuota en la base de datos
        $numeroCuota ++;
        $cuota = $cuotaMensual;
        $fechaVencimientoStr = $fechaVencimiento->format('Y-m-d');
        $stmtInsertarCuota->execute();
    }

    // Añadir la frecuencia de pago a la fecha de vencimiento
    if ($frecuencia === "mensual") {
        $fechaVencimiento->add(new DateInterval("P1M"));
    } elseif ($frecuencia === "trimestral" && $i % 3 === 0) {
        $fechaVencimiento->add(new DateInterval("P3M"));
    } elseif ($frecuencia === "semestral" && $i % 6 === 0) {
        $fechaVencimiento->add(new DateInterval("P6M"));
    }

}
          // Devolver un mensaje al script
          $response = ["success" => true, "message" => "Cuotas calculadas y guardadas con éxito", "idPrestamo" => $idPrestamo];  $idPrestamo;
          header('Content-Type: application/json');
          echo json_encode($response);
        }catch (Exception $e) {
            // Devolver un mensaje de error en caso de excepción
            $response = ["success" => false, "message" => "Error en el cálculo y guardado de cuotas: " . $e->getMessage()];
            header('Content-Type: application/json');
            echo json_encode($response);
        } 
}




 //obtenemos los datos del prestamo a amortizar
 function encabezado($data) {
    include "../../config/conexion.php";

    $stm = $conexion->prepare(SQL_ENCABEZADO);
    $stm->bind_param("i", $data);

    if($stm->execute()) {
        $result = $stm->get_result();
        return $result->fetch_all();
    }
}

function obtenerDatos($prestamo) {
    include "../../config/conexion.php";

    $stm = $conexion->prepare(SELECCIONAR_PRESTAMO);
    $stm->bind_param("i", $prestamo);

    if($stm->execute()) {
        $result = $stm->get_result();
        return $result->fetch_all();
    }
}
//obtener codigo de clientes
function obtenerCodigosClientes()
{
    include "../config/conexion.php";
    try {

        $stm = $conexion->prepare(OBTENER_CLIENTES_CODIGOS);
        if ($stm->execute()) {
            return $stm->get_result();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

//función para obtener lista de socios
function listarPrestamos($cod){
    include "../config/conexion.php";
    $stm = $conexion->prepare(OBTENER_TODOS_PRESTAMOS);
    $stm->bind_param("s", $cod);

    if($stm->execute()) {
        $result = $stm->get_result();

        // Utiliza un bucle para obtener los resultados
        $results = array();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    } else {
        // Manejar el error si la ejecución falla
        return null;
    }
}

function eliminarPrestamo(){
    include "../config/conexion.php";
    session_start();
    if (!isset($_SESSION["user"])) {
        // No hay usuario autenticado, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "No se ha iniciado sesión"]);
        return;
    }

    $user = $_SESSION["user"];
    $id = $_POST["posicion"];
    $pass = $encriptar($_POST["pass"]); // Asegúrate de que $encriptar está definido y funciona correctamente

    // Verificar la contraseña del usuario
    $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
    $stm->bind_param("ss", $user, $pass);

    if (!$stm->execute() || $stm->fetch() === null) {
        // La contraseña no es válida, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    } else { // Cerrar el conjunto de resultados del primer uso
        $stm->close();

        $stm = $conexion->prepare(ELIMINAR_PRESTAMO);
        $stm->bind_param("i", $id);

        if ($stm->execute()) {
            // Éxito al eliminar usuario
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Prestamo eliminado correctamente"]);
        } else {
            // Error al ejecutar la consulta
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Error al eliminar el prestamo"]);
        }
    }
}

//obtiene parametros de formulario mediante POST
function obtenerParametros(){
    return array(
                    "monto"          =>  $_POST["monto"],
                    "destino"        =>  $_POST["destino"],
                    "tasaInteres"       =>  $_POST["interes"],
                    "fechaInicio"        =>  $_POST["fInicio"],
                    "socio" =>  $_POST["socio"],
                    "plazo_anio" =>  $_POST["plazo"],
                    "plazo_cuota"           =>  $_POST["plazocuota"]
                );
}


function listarPrestamosMora(){
    include "../config/conexion.php";
    $stm = $conexion->prepare(OBTENER_TODOS_PRESTAMOS_MORA);

    if($stm->execute()) {
        $result = $stm->get_result();

        // Utiliza un bucle para obtener los resultados
        $results = array();
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    } else {
        // Manejar el error si la ejecución falla
        return null;
    }
}

function listarPrestamosSocio(){
    include "../config/conexion.php";
    $stm = $conexion->prepare(PRESTAMOS_POR_SOCIO);
    $stm->bind_param("i", $_SESSION["codeUser"]);
    if($stm->execute()){
       $data =  $stm->get_result();
       return $data->fetch_all();
    }
    return null;
}
