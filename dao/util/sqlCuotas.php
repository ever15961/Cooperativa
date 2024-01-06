<?php
//Obtener las cuotas sin pagar por mes
define("TODS_CUOTAS_MES", "SELECT
cuota.numeroCuota, 
cuota.montoCuota, 
cuota.fechavencimiento, 
cuota.estado
FROM
cuota
INNER JOIN prestamo
ON cuota.prestamo = prestamo.id
WHERE EXTRACT(MONTH FROM cuota.fechavencimiento)= ?");

//obtener detalle de prestamo
define("OBTENER_DETALLE_PRESTAMO", "SELECT CONCAT(s.nombre,' ',s.apellido) nombre,p.montoPrestamo monto, p.destinoPrestamo destino,
                                    p.plazo_anio plazo
                                    FROM prestamo p 
                                    INNER JOIN socio s 
                                    ON s.id = p.socio
                                    WHERE p.codigo = ?;");

define("OBTENER_CUOTAS_PRESTAMO", "SELECT c.id,p.codigo,c.numeroCuota,c.montoCuota,c.fechavencimiento,c.estado
                                    FROM prestamo p 
                                    INNER JOIN cuota c
                                    ON c.prestamo = p.id
                                    WHERE p.codigo = ?
                                    ORDER BY c.numeroCuota;");

define("OBTENER_PRESTAMOS_CODIGOS", "SELECT codigo FROM prestamo");
define("LISTA_PRESTAMOS_SOCIOS", "SELECT p.codigo,p.montoPrestamo,i.destino,p.fechaInicio FROM prestamo p 
INNER JOIN socio s 
ON s.id = p.socio
INNER JOIN interes i 
ON i.id = p.destinoPrestamo
INNER JOIN usuario u 
ON u.id = s.usuario
WHERE u.id = ?;");

define("CUOTAS_NO_PAGADAS","SELECT c.id,p.codigo,c.numeroCuota,c.montoCuota,c.fechavencimiento,c.estado
FROM prestamo p 
INNER JOIN cuota c
ON c.prestamo = p.id
WHERE p.codigo = ? and c.estado=1
ORDER BY c.numeroCuota;");

define("CUOTAS_PAGADAS","SELECT c.id,p.codigo,c.numeroCuota,c.montoCuota,c.fechavencimiento,c.estado
FROM prestamo p 
INNER JOIN cuota c
ON c.prestamo = p.id
WHERE p.codigo = ? and c.estado=2
ORDER BY c.numeroCuota;");

define("TODAS_CUOTAS","SELECT c.numeroCuota, c.montoCuota, c.fechavencimiento, c.estado FROM cuota c
INNER JOIN prestamo p 
ON p.id = c.prestamo
WHERE p.codigo = ?");

define("SELECCIONAR_CUOTA", "SELECT c.id,p.id as codigo FROM prestamo p 
            INNER JOIN cuota c 
            ON c.prestamo = p.id
            WHERE p.codigo = ? AND c.numeroCuota = ?;");

define("ACTUALIZAR_CUOTA","UPDATE cuota SET estado = 2 WHERE id = ?");

define("OBTENER_CUOTAS_PAGADAS","SELECT count(*) as cuotas_pagadas FROM cuota INNER JOIN prestamo ON cuota.prestamo = prestamo.id where cuota.prestamo=? and cuota.estado=2");
    define("OBTENER_TOTAL_CUOTAS","SELECT count(*) as total_cuotas FROM cuota INNER JOIN prestamo ON cuota.prestamo = prestamo.id where cuota.prestamo=?");

    define("ACTUALIZAR_ESTADO_PRESTAMO","UPDATE prestamo SET estadoPrestamo = 2 WHERE prestamo.id = ?");
