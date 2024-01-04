<?php 
    include "util/sqlAmortizacionP.php";

    //obtenemos los datos del prestamo a amortizar
    function encabezado_amortizacion($data) {
        include "../config/conexion.php";

        $stm = $conexion->prepare(SQL_PRUEBA);
        $stm->bind_param("i", $data);

        if($stm->execute()) {
            $result = $stm->get_result();
            return $result->fetch_all();
        }
    }

    function obtenerAmortizacion($prestamo, $socio) {
        include "../config/conexion.php";

        $stm = $conexion->prepare(SELECCIONAR_PRESTAMOS_AMORTIZACION);
        $stm->bind_param("ii", $prestamo, $socio);

        if($stm->execute()) {
            $result = $stm->get_result();
            return $result->fetch_all();
        }
    }

    function obtenerDestinosPopulares() {
        include "../config/conexion.php";

        $stm = $conexion->query(CANTIDAD_PRESTAMO_DESTINO);
       if($stm) {
        return $stm->fetch_all();
       }
    }

    function obtenerPrestamosPendientes($data) {
        include "../config/conexion.php";

        $stm = $conexion->prepare(SELECCIONAR_PRESTAMO_PENDIENTE_POR_SOCIO);
        $stm->bind_param("s", $data);
        if($stm->execute()) {
            $resultado = $stm->get_result();
            return $resultado->fetch_all();
        }
    }

    function obtenerSocioP($data) {
        include "../config/conexion.php";

        $stm = $conexion->prepare(SELECCIONAR_SOCIO_PRESTAMO);
        $stm->bind_param("s", $data);
        if($stm->execute()) {
            $resultado = $stm->get_result();
            return $resultado->fetch_all();
        }
    }

    function obtenerTodosLosPrestamos($data) {
        include "../config/conexion.php";

        $stm = $conexion->prepare(SELECCIONAR_PRESTAMOS_REPORTE);
        $stm->bind_param("s", $data);
        if($stm->execute()) {
            $resultado = $stm->get_result();
            return $resultado->fetch_all();
        }
    }
?>