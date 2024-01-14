<?php 

    //ingresar usuario
    define("COMPROBAR_USUARIOEMP","SELECT u.usuario,u.rol FROM usuario u
                                INNER JOIN empleado e 
                                ON e.usuario = u.id
                                WHERE u.usuario =? AND u.clave =?");                         

    //ingresar usuario
    define("INGRESAR_USUARIO","INSERT INTO usuario(usuario,clave,rol) VALUES(?,?,?)");
    //ingresar usuarioSocio
    define("COMPROBAR_USUARIOSOC","SELECT u.usuario,u.rol,u.id FROM usuario u
                                INNER JOIN socio e 
                                ON e.usuario = u.id
                                WHERE u.usuario =? AND u.clave =?");
    //ingresardatos
    define("INGRESAR_EMPLEADO",
    "INSERT INTO empleado(nombre,apellido,identificacion,usuario)
     VALUES(?,?,?,?)");

    //ingresar nuevo numero de identificacion
    define("INGRESAR_IDENTIFICACION","INSERT INTO identificacion(numero,tipoIdentificacion)
            VALUES(?,?)");

    //obtener usuario recien creado
    define("SELECCIONAR_ULTIMO_USUARIO","SELECT MAX(id) FROM usuario");

    //obtener id de identificación recien creada
    define("SELECCIONAR_ULTIMA_IDENTIFICACION","SELECT MAX(id) FROM identificacion");

    //listando empleados
    define("SELECCIONAR_TOODS_EMPLEADOS","SELECT u.usuario,nombre,apellido,i.numero,ti.tipo,u.rol,e.id
                                       FROM empleado e
                                       INNER JOIN identificacion i
                                       ON i.id = e.identificacion
                                       INNER JOIN tipoidentificacion ti
                                       ON ti.id = i.tipoIdentificacion
                                       INNER JOIN usuario u
                                       ON u.id = e.usuario
                                       WHERE u.id != 1");

    //obtener claves primarias
    define("OBTENER_CLAVES_PRIMARIAS","SELECT e.id empleado ,i.id identificacion,u.id usuario FROM empleado e
                                       INNER JOIN identificacion i 
                                       ON i.id = e.identificacion
                                       INNER JOIN usuario u 
                                       ON u.id = e.usuario
                                       where e.id=?");

   //actualizar Empleado
    define("ACTUALIZAR_EMPLEADO","UPDATE empleado SET nombre=?,apellido=? WHERE id=?");

    //actualizar identificacion
    define("ACTUALIZAR_IDENTIFICACION","UPDATE  identificacion SET numero=?,tipoIdentificacion=? WHERE id=?");

    define("ACTUALIZAR_USUARIOROL","UPDATE  usuario SET rol=? WHERE id=?");

    define("ACTUALIZAR_USUARIOCLAVE","UPDATE  usuario SET clave=? WHERE id=?");
    
    //eliminar socio
    define("ELIMINAR_EMPLEADO","DELETE FROM empleado WHERE id = ?");

    define("ELIMINAR_IDENTIFICACION","DELETE FROM identificacion where id=?");

    //obtener id empleado
    define("SELECCIONAR_EMPLEADO","SELECT identificacion FROM empleado where id=?");
    define("VERIFICAR_USUARIO_EXISTE","SELECT * FROM usuario where usuario = ?");
    define("VERIFICAR_CORREO_EXISTE","SELECT u.usuario FROM socio s
    INNER JOIN usuario u
    ON u.id=s.usuario
     where correo = ?");
//seleccionar usuario
    define("SELECCIONAR_USUARIO","SELECT usuario FROM socio where correo = ?");

      //actualizar identificacion
      define("ACTUALIZAR_CLAVE","UPDATE  usuario SET clave=? WHERE id=?");


      //Socios
      
    //ingresar usuario
    define("INGRESAR_USUARIO_SOCIO","INSERT INTO usuario(usuario,clave,rol) VALUES(?,?,3)");

     //ingresar socio
     define("INGRESAR_SOCIO",
     "INSERT INTO socio(nombre,apellido,identificacion,telefono,codigoSocio,usuario,direccion,correo)
      VALUES(?,?,?,?,?,?,?,?)");

    //actualizar socio
     define("ACTUALIZAR_SOCIO","UPDATE socio SET nombre=?,apellido=?,telefono=?,direccion=?,correo=? WHERE id=?");
 
  

     //obtener id socio
     define("SELECCIONAR_SOCIO","SELECT usuario,identificacion FROM socio where id = ?");
 
     define("VERIFICAR_CORREO_EXISTE_ACTUALIZAR","SELECT * FROM socio where correo = ? and id!=?");
 
