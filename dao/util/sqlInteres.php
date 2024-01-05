<?php 

    //ingresar interes
    define("INGRESAR_INTERES","INSERT INTO interes(destino, tasaInteres) VALUES(?,?)");
   //ingresar usuario
   define("COMPROBAR_USUARIOEMP","SELECT e.nombre,e.apellido,u.rol FROM usuario u
   INNER JOIN empleado e 
   ON e.usuario = u.id
   WHERE u.usuario =? AND u.clave =?");   


 

define("ELIMINAR_INTERES","DELETE FROM interes where id=?");


 
    //listando socios
    define("SELECCIONAR_TOODS_INTERES","SELECT destino,tasaInteres,id
                                       FROM interes
                                       ");


   //actualizar interes
    define("ACTUALIZAR_INTERES","UPDATE interes SET destino=?,tasaInteres=? WHERE id=?");

  
