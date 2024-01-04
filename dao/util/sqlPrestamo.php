<?php 

    //ingresar usuario
    define("OBTENER_COINCIDENCIAS","SELECT nombre,apellido FROM socio s
    INNER JOIN identificacion i 
    ON i.id = s.identificacion
    WHERE i.numero LIKE ? OR
          s.nombre LIKE '?' OR 
          s.apellido LIKE ? OR 
          s.telefono LIKE ? OR 
          s.codigoSocio LIKE ?");

//obtener todos los prestamos

    define("OBTENER_TODOS_PRESTAMOS","SELECT s.nombre,
    s.apellido,s.direccion,p.montoPrestamo,p.destinoPrestamo,p.estadoPrestamo,p.fechaInicio,i.destino,p.id
    FROM
    prestamo p
    INNER JOIN
    socio s
    ON p.socio = s.id
    INNER JOIN
    interes i
    ON i.id = p.estadoPrestamo
    where s.codigoSocio=?");

    //Guarda el prestamo

    define("GUARDAR_PRESTAMOS","INSERT INTO prestamo(codigo,montoPrestamo,destinoPrestamo,fechaInicio,
    socio,plazo_anio,plazo_cuota,estadoPrestamo,amortizacion) VALUES(?,?,?,?,?,?,?,1,0)");

    //guarda las cuotas

    define("GUARDAR_CUOTAS","INSERT INTO cuota(prestamo,numeroCuota,montoCuota,fechaVencimiento,interes,principal,saldoPendiente,estado) 
    VALUES(?,?,?,?,?,?,?,1)");

       //guarda las cuotas

       define("PAGAR_CUOTA","UPDATE cuota SET estado=2 WHERE id=?");

       //obtener prestamo recien creado
       define("SELECCIONAR_ULTIMO_PRESTAMO","SELECT MAX(id) FROM prestamo");


    //Obtener las cuotas 
    define("TODS_CUOTAS","SELECT
    cuota.numeroCuota, 
    cuota.montoCuota, 
    cuota.fechavencimiento, 
    cuota.estado
    FROM
    cuota
    INNER JOIN
    prestamo
    ON 
        cuota.prestamo = prestamo.id");
       
       
       //Obtener las cuotas por prestamo
    define("TODS_CUOTAS_PRES","SELECT
    cuota.numeroCuota, 
    cuota.montoCuota, 
    cuota.fechavencimiento, 
    cuota.estado,
    cuota.id
    FROM
    cuota
    INNER JOIN
    prestamo
    ON 
    cuota.prestamo = prestamo.id
    where cuota.prestamo=?");

           //Eliminar prestamo
           define("ELIMINAR_PRESTAMO","DELETE FROM prestamo where id=?");

           define("COMPROBAR_USUARIOEMP","SELECT u.usuario,u.rol FROM usuario u
           INNER JOIN empleado e 
           ON e.usuario = u.id
           WHERE u.usuario =? AND u.clave =?");   
           
              //seleccionar los prestamos de cada socio para su amortizacion
    define("SELECCIONAR_PRESTAMOS_AMORTIZACION", "SELECT p.id, p.plazo_anio, p.plazo_cuota, i.destino, p.fechaInicio, p.estadoPrestamo
    FROM prestamo p 
    INNER JOIN 
    socio s ON s.id=p.socio
    INNER JOIN 
    interes i ON i.id=p.destinoPrestamo
    WHERE s.codigoSocio = ?");


define("OBTENER_CUOTAS_PAGADAS","SELECT count(*) as cuotas_pagadas FROM cuota INNER JOIN prestamo ON cuota.prestamo = prestamo.id where cuota.prestamo=? and cuota.estado=2");
    define("OBTENER_TOTAL_CUOTAS","SELECT count(*) as total_cuotas FROM cuota INNER JOIN prestamo ON cuota.prestamo = prestamo.id where cuota.prestamo=?");

    define("ACTUALIZAR_ESTADO_PRESTAMO","UPDATE prestamo SET estadoPrestamo = 2 WHERE prestamo.id = ?");

    define("SELECCIONAR_PRESTAMO", "SELECT c.id,c.fechavencimiento, c.montoCuota, c.principal, c.interes, c.estado, c.saldoPendiente FROM cuota c 
    INNER JOIN prestamo p 
     ON c.prestamo = p.id 
     INNER JOIN socio s on s.id=p.socio
     WHERE p.id = ?
    ORDER BY c.id");

define("SQL_ENCABEZADO", "SELECT p.id, p.codigo,p.montoPrestamo, i.tasaInteres, p.plazo_anio, p.plazo_cuota, i.destino, s.nombre, s.apellido, s.direccion,p.fechaInicio FROM prestamo p
INNER JOIN socio s ON s.id = p.socio
INNER JOIN interes i ON i.id = p.destinoPrestamo WHERE p.id = ?");

define("OBTENER_CLIENTES_CODIGOS", "SELECT codigoSocio FROM socio");

define("OBTENER_TODOS_PRESTAMOS_MORA","SELECT s.nombre, s.apellido, s.direccion, p.montoPrestamo, i.destino, p.fechaInicio, p.estadoPrestamo, p.id FROM socio s JOIN prestamo p ON s.id = p.socio JOIN cuota c 
ON p.id = c.prestamo
INNER JOIN interes i
ON i.id=p.destinoPrestamo WHERE c.estado = 1 AND c.fechaVencimiento < CURDATE() AND p.estadoPrestamo = 1 GROUP BY p.id");

