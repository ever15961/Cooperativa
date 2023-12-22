<?php 
//creando constantes
include "util/sqlUsuario.php";

//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            ingresarEmpleado();
        break;

        case "editar" :
                editarUsuario();
            break;

        case "eliminar":
                eliminarUsuario();
            break;

            case "iniciarSesion":
                iniciarSesion();
            break;

        default :
            break;
    }
}

function iniciarSesion(){
    include "../config/conexion.php";
    include "../dao/util/sqlUsuario.php";

    //session_start();

    $username = $_REQUEST["username"];
    $password = $encriptar($_REQUEST["clave"]);

    
    $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
    $stm->bind_param("ss",$username,$password);

    if($stm->execute()){
        $data = $stm->get_result();
        
        $data = $data->fetch_assoc();

        session_start();

        $_SESSION["user"] = $data["usuario"];
        if($data["rol"]===1){
            $_SESSION["rol"] = "Admin";

        }else{
            $_SESSION["rol"] = "Empleado"; 
        }
        

    }else{

    }
    
}

function eliminarUsuario(){
    include "../config/conexion.php";
    session_start();
    if (!isset($_SESSION["user"])) {
        // No hay usuario autenticado, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "No se ha iniciado sesión"]);
        return;
    }

    $user = $_SESSION["user"];
    $id = $_POST["posicion"];
    $pass = $encriptar($_POST["pass"]); // Asegúrate de que $encriptar está definido y funciona correctamente

    // Verificar la contraseña del usuario
    $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
    $stm->bind_param("ss", $user, $pass);

    if (!$stm->execute() || $stm->fetch() === null) {
        // La contraseña no es válida, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    } else { // Cerrar el conjunto de resultados del primer uso
        $stm->close();

        // Obtener el socio antes de eliminar
        $stm = $conexion->prepare(SELECCIONAR_EMPLEADO);
        $stm->bind_param("i", $id);

        if (!$stm->execute()) {
            // Error al obtener el socio, devolver respuesta de error
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Error al obtener el empleado"]);
        } else {
            $empleado = $stm->get_result()->fetch_assoc();

            if (!$empleado) {
                // No se encontró el socio, devolver respuesta de error
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "No se encontró el empleado"]);
            } else {

 //Eliminar dui
 $stm = $conexion->prepare(ELIMINAR_IDENTIFICACION);
 $stm->bind_param("i", $empleado["identificacion"]);
 $stm->execute();

        $stm = $conexion->prepare(ELIMINAR_EMPLEADO);
        $stm->bind_param("i", $id);

        if ($stm->execute()) {
            // Éxito al eliminar usuario
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Usuario eliminado correctamente"]);
        } else {
            // Error al ejecutar la consulta
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Error al eliminar usuario"]);
        }
    }
}
}
}



//función para obtener lista de socios
function listarUsuarios(){
    include "../config/conexion.php";
    $stm = $conexion->query(SELECCIONAR_TOODS_EMPLEADOS);
    if($stm){
        return $stm->fetch_all();
    }
    return null;
}



function editarUsuario(){
    include "../config/conexion.php";


    session_start();
      // Obtener la contraseña y el id
      $pass = $encriptar($_POST["pass"]);
      $id = $_POST["id"];
      $usuario = $_SESSION["user"];
      $claveNueva= $_POST["clavenueva"];
  
      // Verificar la contraseña
      $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
      $stm->bind_param("ss", $usuario, $pass);
  
      if ($stm->execute()) {
          $result = $stm->get_result();
  
          // Verificar si hay filas afectadas (usuario y contraseña coinciden)
          if ($result->num_rows > 0) {
              // Obtener otros parámetros
              $posicion = $id;
  
              $empleado = 0;
              $identificacion = 0;
  
              $data = obtenerParametros();
  
              // Obtener claves primarias
              $stm = $conexion->prepare(OBTENER_CLAVES_PRIMARIAS);
              $stm->bind_param("i", $posicion);
  
              if ($stm->execute()) {
                  $result = $stm->get_result();
                  $array = $result->fetch_assoc();
  
                  $empleado = $array["empleado"];
                  $identificacion = $array["identificacion"];
                  $usuario = $array["usuario"];
              }
  
              // Actualizar empleado
              $stm = $conexion->prepare(ACTUALIZAR_EMPLEADO);
              $stm->bind_param("ssi", $data["nombre"], $data["apellido"], $empleado);
  
              if ($stm->execute()) {
                  // Manejar éxito o error según tu lógica de aplicación
              }
  
              // Actualizar rol de usuario
              $stm = $conexion->prepare(ACTUALIZAR_USUARIOROL);
              $stm->bind_param("ii", $data["usuario_privilegio"], $usuario);
  
              if ($stm->execute()) {
                  // Manejar éxito o error según tu lógica de aplicación
              }
              if($claveNueva=="true"){
// Actualizar clave de usuario
                $contra=$encriptar($data["claveNueva1"]);
                $stm = $conexion->prepare(ACTUALIZAR_USUARIOCLAVE);
                $stm->bind_param("si", $contra, $usuario);

              $stm->execute();
    
              }
              // Actualizar identificación
              $stm = $conexion->prepare(ACTUALIZAR_IDENTIFICACION);
              $stm->bind_param("ssi", $data["nIdentificacion"], $data["tIdentificacion"], $identificacion);
  
              if ($stm->execute()) {
                  // Manejar éxito o error según tu lógica de aplicación
              }
  
              // Enviar respuesta JSON
              header('Content-Type: application/json');
              echo json_encode(["success" => true, "message" => "Modificado con éxito"]);
          } else {
              // Contraseña incorrecta
              header('Content-Type: application/json');
              echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
          }
      } else {
          // Error en la ejecución de la consulta
          header('Content-Type: application/json');
          echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta"]);
      }
}

//función que ingresa el empleado a la bd
function ingresarEmpleado()
{
    //incluyendo la conexion a bd
    include "../config/conexion.php";

  // Obtener parámetros del formulario
  $data = obtenerParametros();

  // Ingresar usuario
  $idUsuario = 0;
  $pass=$encriptar($data["clave"]);
  $stm = $conexion->prepare(INGRESAR_USUARIO);
  $stm->bind_param("ssi", $data["usuario"], $pass, $data["usuario_privilegio"]);

  if ($stm->execute()) {
      $stm = $conexion->query(SELECCIONAR_ULTIMO_USUARIO);
      if ($stm) {
          $data["idUsuario"] = $stm->fetch_row()[0];
      }
  } else {
      // Manejar error en la ejecución de la consulta
      header('Content-Type: application/json');
      echo json_encode(["success" => false, "message" => "Error al ingresar usuario"]);
      return;
  }

  // Ingresar identificación
  $idIdentificacion = 0;
  $stm = $conexion->prepare(INGRESAR_IDENTIFICACION);
  $stm->bind_param("si", $data["nIdentificacion"], $data["tIdentificacion"]);
  if ($stm->execute()) {
      $stm = $conexion->query(SELECCIONAR_ULTIMA_IDENTIFICACION);
      if ($stm) {
          $data["nIdentificacion"] = $stm->fetch_row()[0];
      }
  } else {
      // Manejar error en la ejecución de la consulta
      header('Content-Type: application/json');
      echo json_encode(["success" => false, "message" => "Error al ingresar identificación"]);
      return;
  }

  // Ingresar Empleado
  $stm = $conexion->prepare(INGRESAR_EMPLEADO);
  $stm->bind_param("ssii", $data["nombre"], $data["apellido"], $data["nIdentificacion"], $data["idUsuario"]);

  if ($stm->execute()) {
      // Operaciones exitosas
      echo json_encode(["success" => true, "message" => "Registro ingresado con éxito"]);
  } else {
      // Manejar error en la ejecución de la consulta
      header('Content-Type: application/json');
      echo json_encode(["success" => false, "message" => "Error al ingresar empleado"]);
  }
    
}

//obtiene parametros de formulario mediante POST
function obtenerParametros(){
    return array(
                    "nombre"          =>  $_POST["nombres"],
                    "apellido"        =>  $_POST["apellidos"],
                    "tIdentificacion" =>  $_POST["tipoIdentificacion"],
                    "nIdentificacion" =>  $_POST["nIdentificacion"],
                    "usuario"         =>  $_POST["usuario"],
                    "clave"           =>  $_POST["clave"],
                    "clave2"           =>  $_POST["clave2"],
                    "usuario_privilegio"  =>  $_POST["usuario_privilegio"],
                    "claveNueva1"  =>  $_POST["usuario_clave_nueva_1"],
                    "claveNueva2"  =>  $_POST["usuario_clave_nueva_2"]
                );
}


//constantes de setencias sql
/*function crearConstantes(){
    //ingresar usuario
    define("INGRESAR_USUARIO","INSERT INTO usuario(usuario,clave,rol) VALUES(?,?,3)");

    //ingresar socio
    define("INGRESAR_SOCIO",
    "INSERT INTO socio(nombre,apellido,identificacion,direccion,telefono,codigoSocio,usuario)
     VALUES(?,?,?,?,?,?,?)");

    //ingresar nuevo numero de identificacion
    define("INGRESAR_IDENTIFICACION","INSERT INTO identificacion(numero,tipoIdentificacion)
            VALUES(?,?)");

    //obtener usuario recien creado
    define("SELECCIONAR_ULTIMO_USUARIO","SELECT MAX(id) FROM usuario");

    //obtener id de identificación recien creada
    define("SELECCIONAR_ULTIMA_IDENTIFICACION","SELECT MAX(id) FROM identificacion");

    //listando socios
    define("SELECCIONAR_TOODS_SOCIOS","SELECT nombre,apellido,i.numero, direccion, telefono,ti.tipo
                                       FROM socio s
                                       INNER JOIN identificacion i
                                       ON i.id = s.identificacion
                                       INNER JOIN tipoIdentificacion ti
                                       ON ti.id = i.tipoIdentificacion");

    //obtener claves primarias
    define("OBTENER_CLAVES_PRIMARIAS","SELECT s.id socio ,i.id identificacion FROM socio s
                                       INNER JOIN identificacion i 
                                       ON i.id = s.identificacion
                                       LIMIT ?,1;");

   //actualizar socio
    define("ACTUALIZAR_SOCIO","UPDATE FROM socio SET nombre=?,apellido=?,direccion=?,telefono=? WHERE id=?");

    //actualizar identificacion
    define("ATUALIZAR_IDENTIFICACION","UPDATE FROM identificacion SET numero,tipoIdentificacion=? WHERE id=?");
    
    //eliminar socio
    define("ELIMINAR_SOCIO","DELETE FROM socio WHERE id = (SELECT id FROM socio LIMIT ?,1)");

}*/
