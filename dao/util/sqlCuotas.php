<?php

//Obtener las cuotas sin pagar por mes
define("TODS_CUOTAS_MES","SELECT
cuota.numeroCuota, 
cuota.montoCuota, 
cuota.fechavencimiento, 
cuota.estado
FROM
cuota
INNER JOIN
prestamo
ON 
    cuota.prestamo = prestamo.id
    where EXTRACT(MONTH FROM cuota.fechavencimiento)=?");

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