<?php 
//creando constantes
include "util/sqlInteres.php";

//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            ingresarInteres();
            break;

        case "editar":
            editarInteres();
            break;

        case "eliminar":
            eliminarInteres();
            break;

        default:
            break;
    }
}



function eliminarInteres()
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
        $stm = $conexion->prepare(ELIMINAR_INTERES);
        $stm->bind_param("i", $id);

                if ($stm->execute()) {
                    // Éxito al eliminar el socio, devolver respuesta de éxito
                    header('Content-Type: application/json');
                    echo json_encode(["success" => true, "message" => "Interes eliminado correctamente"]);
                } else {
                    // Error al eliminar el socio, devolver respuesta de error
                    header('Content-Type: application/json');
                    echo json_encode(["success" => false, "message" => "Error al eliminar el interes"]);
                }
            }
        }
    




//función para obtener lista de socios
function listarInteres()
{
    include "../config/conexion.php";
    $stm = $conexion->query(SELECCIONAR_TOODS_INTERES);
    if ($stm) {
        return $stm->fetch_all();
    }
    return null;
}



function editarInteres()
{
    include "../config/conexion.php";

    try {

        session_start();
        // Obtener la contraseña y el id
        $pass = $encriptar($_POST["pass"]);
        $id = $_POST["id"];
        $usuario=$_SESSION["user"];
        $data = obtenerParametros();
        // Verificar la contraseña
        $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
        $stm->bind_param("ss", $usuario, $pass);  

        if ($stm->execute()) {
            $result = $stm->get_result();

            // Verificar si hay filas afectadas (usuario y contraseña coinciden)
            if ($result->num_rows > 0) {
                // Obtener otros parámetros
                $posicion = $id;

                $stm = $conexion->prepare(ACTUALIZAR_INTERES);
                $stm->bind_param("sii", $data["destino"], $data["interes"],$posicion);

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
function ingresarInteres()
{
    // Incluyendo la conexión a la base de datos
    include "../config/conexion.php";

    // Obtener parámetros del formulario
    $data = obtenerParametros();

    // Ingresando datos a la base de datos


    $stm = $conexion->prepare(INGRESAR_INTERES);
    $stm->bind_param("si", $data["destino"], $data["interes"]);


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




//obtiene parametros de formulario mediante POST
function obtenerParametros()
{
    return array(
        "destino" => $_POST["destino"],
        "interes" => $_POST["interes"]
    );
}


