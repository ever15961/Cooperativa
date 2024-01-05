<?php 

    //ingresar usuario
    define("INGRESAR_USUARIO","INSERT INTO usuario(usuario,clave,rol) VALUES(?,?,3)");
   //ingresar usuario
   define("COMPROBAR_USUARIOEMP","SELECT e.nombre,e.apellido,u.rol FROM usuario u
   INNER JOIN empleado e 
   ON e.usuario = u.id
   WHERE u.usuario =? AND u.clave =?");   
    //ingresar socio
    define("INGRESAR_SOCIO",
    "INSERT INTO socio(nombre,apellido,identificacion,telefono,codigoSocio,usuario,direccion,correo)
     VALUES(?,?,?,?,?,?,?,?)");

    //ingresar nuevo numero de identificacion
    define("INGRESAR_IDENTIFICACION","INSERT INTO identificacion(numero,tipoIdentificacion)
            VALUES(?,?)");

define("ELIMINAR_IDENTIFICACION","DELETE FROM identificacion where id=?");
define("ELIMINAR_USUARIO","DELETE FROM usuario where id=?");

    //obtener usuario recien creado
    define("SELECCIONAR_ULTIMO_USUARIO","SELECT MAX(id) FROM usuario");

    //obtener id de identificación recien creada
    define("SELECCIONAR_ULTIMA_IDENTIFICACION","SELECT MAX(id) FROM identificacion");

    //listando socios
    define("SELECCIONAR_TOODS_SOCIOS","SELECT nombre,apellido,i.numero, codigoSocio, telefono,ti.tipo,s.id,s.direccion,
    s.correo
                                       FROM socio s
                                       INNER JOIN identificacion i
                                       ON i.id = s.identificacion
                                       INNER JOIN tipoIdentificacion ti
                                       ON ti.id = i.tipoIdentificacion");

    //obtener claves primarias
    define("OBTENER_CLAVES_PRIMARIAS","SELECT s.id socio ,i.id identificacion FROM socio s
                                       INNER JOIN identificacion i 
                                       ON i.id = s.identificacion
                                       where s.id=?");

   //actualizar socio
    define("ACTUALIZAR_SOCIO","UPDATE socio SET nombre=?,apellido=?,telefono=?,direccion=?,correo=? WHERE id=?");

    //actualizar identificacion
    define("ACTUALIZAR_IDENTIFICACION","UPDATE  identificacion SET numero=?,tipoIdentificacion=? WHERE id=?");
    
    //eliminar socio
    define("ELIMINAR_SOCIO","DELETE FROM socio WHERE id = ?");

    //obtener id socio
    define("SELECCIONAR_SOCIO","SELECT usuario,identificacion FROM socio where id = ?");

    define("VERIFICAR_USUARIO_EXISTE","SELECT * FROM usuario where usuario = ?");

    define("VERIFICAR_CORREO_EXISTE","SELECT * FROM socio where correo = ?");
    define("VERIFICAR_CORREO_EXISTE_ACTUALIZAR","SELECT * FROM socio where correo = ? and id!=?");
