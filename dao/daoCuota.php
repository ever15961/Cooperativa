<?php 

//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{

    switch ($op) {
        case "obtenerCuotas":
            obtenerCuotas();
            break;
        case "obtenerIdCuota":
            obtenerIdCuota($_POST["codigo"], $_POST["numCuota"]);
            break;

        default:
            break;
    }

}



//función para obtener lista de socios
function listarCuotasMes()
{
    include "../config/conexion.php";
    $stm = $conexion->query(TODS_CUOTAS_MES);
    $stm->bind_param("s", $_POST["mes"]);
    if ($stm) {
        return $stm->fetch_all();
    }
    return null;
}

//función para obtener lista de socios
function listarCuotas()
{
    include "../config/conexion.php";
    $stm = $conexion->query(TODS_CUOTAS);
    if ($stm) {
        return $stm->fetch_all();
    }
    return null;
}

function comprobarCodigoPrestamo()
{
    if (!isset($_POST["codigo"])) {
        return false;
    }
    return true;
}
function obtenerCuotas()
{
    include "../config/conexion.php";
    include "util/sqlCuotas.php";

    if (comprobarCodigoPrestamo()) {

        $codigo = $_POST["codigo"];

        $stm = $conexion->prepare(OBTENER_DETALLE_PRESTAMO);

        $stm->bind_param("s", $codigo);

        $datos = array();

        if ($stm->execute()) {
            $data = $stm->get_result();

            if ($row = $data->fetch_assoc()) {
                array_push($datos, array(
                    "codigo" => $codigo,
                    "nombre" => $row["nombre"],
                    "monto" => $row["monto"],
                    "destino" => $row["destino"],
                    "plazo" => $row["plazo"]
                ));
            }


            $stm = $conexion->prepare(OBTENER_CUOTAS_PRESTAMO);
            $stm->bind_param("s", $codigo);
            $cuotas = array();
            if ($stm->execute()) {

                $data = $stm->get_result();
                while ($row = $data->fetch_assoc()) {
                    array_push($cuotas, array(
                        "id" => $row["id"],
                        "numCuota" => $row["numeroCuota"],
                        "montoCuota" => $row["montoCuota"],
                        "fechavencimiento" => $row["fechavencimiento"],
                        "estado" => $row["estado"]
                    ));
                }
            }

            array_push($datos, $cuotas);

            echo json_encode($datos);

            return null;
        }
        echo json_encode($datos);


    }
    echo json_encode(array("respuesta" => 0));

}

//obtener codigo de prestamos
function obtenerCodigosPrestamos()
{
    global $conexion;
    try {

        $stm = $conexion->prepare(OBTENER_PRESTAMOS_CODIGOS);
        if ($stm->execute()) {
            return $stm->get_result();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


//Pagar cuota
function obtenerIdCuota($codigo, $numCuota)
{
    include "../config/conexion.php";
    include "../dao/util/sqlCuotas.php";

    $id = 0;

    try {

        $stm = $conexion->prepare(SELECCIONAR_CUOTA);
        $stm->bind_param("si", $codigo, $numCuota);

        if ($stm->execute()) {
            $stm2 = $stm->get_result();
            if ($row = $stm2->fetch_assoc()) {
                $id = $row["id"];
                $code = $row["codigo"];
            }

            $stm = $conexion->prepare(ACTUALIZAR_CUOTA);
            $stm->bind_param("i",$id);
            if($stm->execute()){
                $totalCuotas = obtenerTotalCuotas($code);
                $cuotasPagadas = obtenerCuotasPagadas($code);
                if ($cuotasPagadas == $totalCuotas) {
                    actualizarEstadoPrestamo($code);
                }
                echo json_encode(array("respuesta" => 0, "id" => $id));
                return null;
            }

        }
    } catch (Exception $e) {
        echo $e->getMessage();
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
?>

