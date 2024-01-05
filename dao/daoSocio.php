<?php
//creando constantes
include "util/sqlSocio.php";

//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            ingresarSocio();
            break;

        case "editar":
            editarSocio();
            break;

        case "eliminar":
            eliminarSocio();
            break;

        default:
            break;
    }
}



function eliminarSocio()
{
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
    $pass = $encriptar($_POST["pass"]);

    // Verificar la contraseña del usuario
    $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
    $stm->bind_param("ss", $user, $pass);

    if (!$stm->execute() || $stm->fetch() === null) {
        // La contraseña no es válida, devolver respuesta de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Contraseña incorrecta"]);
    } else {
        // Cerrar el conjunto de resultados del primer uso
        $stm->close();

        // Obtener el socio antes de eliminar
        $stm = $conexion->prepare(SELECCIONAR_SOCIO);
        $stm->bind_param("i", $id);

        if (!$stm->execute()) {
            // Error al obtener el socio, devolver respuesta de error
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Error al obtener el socio"]);
        } else {
            $socio = $stm->get_result()->fetch_assoc();

            if (!$socio) {
                // No se encontró el socio, devolver respuesta de error
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "No se encontró el socio"]);
            } else {
                //Eliminar dui
                $stm = $conexion->prepare(ELIMINAR_IDENTIFICACION);
                $stm->bind_param("i", $socio["identificacion"]);
                $stm->execute();
                //Eliminar usuario
                $stm = $conexion->prepare(ELIMINAR_USUARIO);
                $stm->bind_param("i", $socio["usuario"]);
                $stm->execute();
                // Eliminar el socio

                $stm = $conexion->prepare(ELIMINAR_SOCIO);
                $stm->bind_param("i", $id);

                if ($stm->execute()) {
                    // Éxito al eliminar el socio, devolver respuesta de éxito
                    header('Content-Type: application/json');
                    echo json_encode(["success" => true, "message" => "Socio eliminado correctamente"]);
                } else {
                    // Error al eliminar el socio, devolver respuesta de error
                    header('Content-Type: application/json');
                    echo json_encode(["success" => false, "message" => "Error al eliminar el socio"]);
                }
            }
        }
    }
}



//función para obtener lista de socios
function listarSocios()
{
    include "../config/conexion.php";
    $stm = $conexion->query(SELECCIONAR_TOODS_SOCIOS);
    if ($stm) {
        return $stm->fetch_all();
    }
    return null;
}



function editarSocio()
{
    include "../config/conexion.php";

    try {

        session_start();
        // Obtener la contraseña y el id
        $pass = $encriptar($_POST["pass"]);
        $id = $_POST["id"];
        $usuario = $_SESSION["user"];

        // Verificar la contraseña
        $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
        $stm->bind_param("ss", $usuario, $pass);

        if ($stm->execute()) {
            $result = $stm->get_result();

            // Verificar si hay filas afectadas (usuario y contraseña coinciden)
            if ($result->num_rows > 0) {
                // Obtener otros parámetros
                $posicion = $id;

                $socio = 0;
                $identificacion = 0;

                $data = obtenerParametros();
            
                // Verificar si el correo ya existe
                $stm = $conexion->prepare(VERIFICAR_CORREO_EXISTE_ACTUALIZAR);
                $stm->bind_param("si", $data["correo"],$id);
                $stm->execute();
                $stm->store_result();
            
                if ($stm->num_rows > 0) {
                    // El correo ya existe
                    header('Content-Type: application/json');
                    echo json_encode(["success" => false, "message" => "El correo electrónico ya está registrado"]);
                    return;
                }
                $stm = $conexion->prepare(OBTENER_CLAVES_PRIMARIAS);
                $stm->bind_param("i", $posicion);

                if ($stm->execute()) {
                    $result = $stm->get_result();
                    $array = $result->fetch_assoc();

                    $socio = $array["socio"];
                    $identificacion = $array["identificacion"];
                }

                $stm = $conexion->prepare(ACTUALIZAR_SOCIO);
                $stm->bind_param("sssssi", $data["nombre"], $data["apellido"], $data["telefono"], $data["direccion"], $data["correo"], $socio);
                $stm->execute();

                $stm = $conexion->prepare(ACTUALIZAR_IDENTIFICACION);
                $stm->bind_param("ssi", $data["nIdentificacion"], $data["tIdentificacion"], $identificacion);

                if ($stm->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode(["success" => true, "message" => "Modificado con exito"]);
                }
            } else {
                // Usuario o contraseña incorrectos
                header('Content-Type: application/json');
                echo json_encode(["success" => false, "message" => "Contraseña incorrectos"]);
            }
        } else {
            // Error en la ejecución de la consulta
            header('Content-Type: application/json');
            echo json_encode(["success" => false, "message" => "Error en la consulta"]);
        }
    } catch (Exception $e) {
        // Captura cualquier excepción y devuelve un mensaje de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
}
//función que ingresa el socio a la bd
function ingresarSocio()
{
    // Incluyendo la conexión a la base de datos
    include "../config/conexion.php";

    // Obtener parámetros del formulario
    $data = obtenerParametros();
    // Verificar si el usuario ya existe
    $stm = $conexion->prepare(VERIFICAR_USUARIO_EXISTE);
    $stm->bind_param("s", $data["usuario"]);
    $stm->execute();
    $stm->store_result();

    if ($stm->num_rows > 0) {
        // El usuario ya existe
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "El usuario ya existe"]);
        return;
    }

    // Verificar si el correo ya existe
    $stm = $conexion->prepare(VERIFICAR_CORREO_EXISTE);
    $stm->bind_param("s", $data["correo"]);
    $stm->execute();
    $stm->store_result();

    if ($stm->num_rows > 0) {
        // El correo ya existe
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "El correo electrónico ya está registrado"]);
        return;
    }
    // Ingresando datos a la base de datos

    // Ingresar usuario
    $idUsuario = 0;
    $clave = $encriptar($data["clave"]);
    $stm = $conexion->prepare(INGRESAR_USUARIO);
    $stm->bind_param("ss", $data["usuario"], $clave);

    if ($stm->execute()) {
        $stm = $conexion->query(SELECCIONAR_ULTIMO_USUARIO);
        if ($stm) {
            $data["idUsuario"] = $stm->fetch_row()[0];
        }
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
    }

    $codigo = obtenerCodigoSocio($data["nombre"], $data["apellido"]);

    // Ingresando socio 
    $stm = $conexion->prepare(INGRESAR_SOCIO);

    $stm->bind_param(
        "ssississ",
        $data["nombre"],
        $data["apellido"],
        $data["nIdentificacion"],
        $data["telefono"],
        $codigo,
        $data["idUsuario"],
        $data["direccion"],
        $data["correo"]
    );

    if ($stm->execute()) {
        // Construir la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Registro ingresado"]);
    } else {
        // Si hay un error, también devolver un JSON con el mensaje de error
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Error al ingresar el registro"]);
    }
}

function obtenerCodigoSocio($nombre, $apellido)
{
    $completo = $nombre . $apellido;
    $completo = str_replace(" ", "", $completo);

    $iteracion = rand(1, 6);

    $codigo = "";

    for ($i = 1; $i <= 6; $i++) {
        if ($i == $iteracion) {
            $n = rand(0, 9);
            $codigo .= $n;

        } else {
            $n = rand(0, strlen($nombre));
            $codigo .= $completo[$n];
            $completo[$n] = " ";
            $completo = str_replace(" ", "", $completo);
        }
    }
    return $codigo;
}


//obtiene parametros de formulario mediante POST
function obtenerParametros()
{
    return array(
        "nombre" => $_POST["nombres"],
        "apellido" => $_POST["apellidos"],
        "telefono" => $_POST["telefono"],
        "tIdentificacion" => $_POST["tipoIdentificacion"],
        "nIdentificacion" => $_POST["nIdentificacion"],
        "usuario" => $_POST["usuario"],
        "clave" => $_POST["clave"],
        "direccion" => $_POST["direccion"],
        "correo" => $_POST["correo"]
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
