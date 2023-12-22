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
    s.apellido,s.direccion,p.montoPrestamo,p.destinoPrestamo,p.fechaInicio,p.estadoPrestamo,p.id
    FROM
    prestamo p
    INNER JOIN
    socio s
    ON p.socio = s.id");

    //Guarda el prestamo

    define("GUARDAR_PRESTAMOS","INSERT INTO prestamo(montoPrestamo,destinoPrestamo,tasaInteres,fechaInicio,
    socio,plazo_anio,plazo_cuota,estadoPrestamo,amortizacion) VALUES(?,?,?,?,?,?,?,1,0)");

    //guarda las cuotas

    define("GUARDAR_CUOTAS","INSERT INTO cuota(prestamo,numeroCuota,montoCuota,fechaVencimiento,interes,principal,saldoPendiente,estado) 
    VALUES(?,?,?,?,?,?,?,1)");

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