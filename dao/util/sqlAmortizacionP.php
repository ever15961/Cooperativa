<?php
    define("SELECCIONAR_PRESTAMOS_AMORTIZACION", "SELECT c.id, c.montoCuota, c.principal, c.interes, c.estado, c.saldoPendiente FROM cuota c 
    INNER JOIN prestamo p 
     ON c.prestamo = p.id 
     INNER JOIN socio s on s.id=p.socio
     WHERE p.id = ? AND s.codigoSocio = ? AND c.estado = 1
    ORDER BY c.id");

    define("SELECCIONAR_PRESTAMO_PARAMETRO", "SELECT p.id, p.montoPrestamo, p.tasaInteres, p.plazo_anio, p.plazo_cuota FROM prestamo p
    WHERE p.id = ?");

    define("SQL_PRUEBA", "SELECT p.id, p.montoPrestamo, p.tasaInteres, p.plazo_anio, p.plazo_cuota, p.destinoPrestamo, s.nombre, s.apellido, s.direccion FROM prestamo p
    INNER JOIN socio s ON s.id = p.socio WHERE p.id = ?");

    define("CANTIDAD_PRESTAMO_DESTINO", "SELECT p.destinoPrestamo, COUNT(p.id) as id FROM prestamo p GROUP BY p.destinoPrestamo ORDER BY COUNT(p.id) DESC");
    
    define("SELECCIONAR_PRESTAMO_PENDIENTE_POR_SOCIO", "SELECT p.fechaInicio, p.destinoPrestamo, p.montoPrestamo, 
    p.tasaInteres, p.saldo_pendiente FROM socio s
    INNER JOIN prestamo p 
    ON s.id=p.socio WHERE p.estadoPrestamo = 1 AND s.codigoSocio = ?");

    define("SELECCIONAR_SOCIO_PRESTAMO", "SELECT s.codigoSocio, s.nombre, s.apellido, s.direccion FROM socio s WHERE s.codigoSocio = ?");
 
    define("SELECCIONAR_PRESTAMOS_REPORTE", "SELECT p.id, p.plazo_anio, p.plazo_cuota, p.destinoPrestamo, p.fechaInicio, p.estadoPrestamo, p.montoPrestamo, p.tasaInteres
    FROM prestamo p 
    INNER JOIN 
    socio s ON s.id=p.socio
    WHERE s.codigoSocio = ?");
 ?>