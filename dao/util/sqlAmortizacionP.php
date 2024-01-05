<?php
define("SELECCIONAR_PRESTAMOS_AMORTIZACION", "SELECT c.id, c.montoCuota, c.principal, c.interes, c.estado, c.saldoPendiente FROM cuota c 
    INNER JOIN prestamo p 
     ON c.prestamo = p.id 
     INNER JOIN socio s 
     on s.id=p.socio
     WHERE p.id = ? AND s.codigoSocio = ?
    ORDER BY c.id");

define("SELECCIONAR_PRESTAMO_PARAMETRO", "SELECT p.id, p.montoPrestamo, p.tasaInteres, p.plazo_anio, p.plazo_cuota FROM prestamo p
    INNER JOIN interes i
    ON i.id=p.destinoPrestamo
    WHERE p.id = ?");

define("SQL_PRUEBA", "SELECT p.id, p.montoPrestamo, p.tasaInteres, p.plazo_anio, p.plazo_cuota, i.destino, s.nombre, s.apellido, s.direccion FROM prestamo p
    INNER JOIN socio s ON s.id = p.socio
    INNER JOIN interes i ON i.id = p.destinoPrestamo WHERE p.id = ?");

define("CANTIDAD_PRESTAMO_DESTINO", "SELECT p.destinoPrestamo, COUNT(p.id) as id FROM prestamo p GROUP BY p.destinoPrestamo ORDER BY COUNT(p.id) DESC");

define("SELECCIONAR_PRESTAMO_PENDIENTE_POR_SOCIO", "SELECT p.fechaInicio, i.destino, p.montoPrestamo, 
p.tasaInteres, MAX(c.saldoPendiente) AS saldoPendiente,c.numeroCuota
FROM socio s
INNER JOIN prestamo p ON s.id = p.socio
INNER JOIN interes i ON i.id = p.destinoPrestamo
INNER JOIN cuota c ON c.prestamo = p.id
WHERE p.estadoPrestamo = 1 AND c.estado = 1 AND s.codigoSocio = ? 
GROUP BY p.fechaInicio, i.destino, p.montoPrestamo, p.tasaInteres
ORDER BY p.fechaInicio");

define("SELECCIONAR_SOCIO_PRESTAMO", "SELECT s.codigoSocio, s.nombre, s.apellido, s.direccion FROM socio s WHERE s.codigoSocio = ?");

define("SELECCIONAR_PRESTAMOS_REPORTE", "SELECT p.id, p.plazo_anio, p.plazo_cuota, i.destino, p.fechaInicio, p.estadoPrestamo, p.montoPrestamo, p.tasaInteres
    FROM prestamo p 
    INNER JOIN 
    socio s ON s.id=p.socio
    INNER JOIN 
    interes i ON i.id=p.destinoPrestamo
    WHERE s.codigoSocio = ?");
?>