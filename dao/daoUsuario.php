<?php
//creando constantes
include "util/sqlUsuario.php";
if (session_status() == PHP_SESSION_NONE) {
    include "util/session_start.php";
}

//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";
$codigo = "";
//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            ingresarEmpleado();
            break;
        case "ingresarSocio":
            ingresarSocio();
            break;
        case "editar":
            editarUsuario();
            break;

        case "eliminar":
            eliminarUsuario();
            break;

        case "iniciarSesion":
            iniciarSesion();
            break;

        case "buscarCorreo":
            buscarCorreo();
            break;

        case "comprobarCodigo":
            comprobarCodigo();
            break;

        case "actualizar":
            actualizarContra();
            break;


        default:
            break;
    }
}


function ingresarSocio()
{
    // Incluyendo la conexión a la base de datos
    include "../config/conexion.php";

    // Obtener parámetros del formulario
    $data = obtenerParametrosSocio();
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
    $stm = $conexion->prepare(INGRESAR_USUARIO_SOCIO);
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
function obtenerParametrosSocio()
{
    return array(
        "nombre" => $_POST["nombres"],
        "apellido" => $_POST["apellidos"],
        "telefono" => $_POST["telefono"],
        "tIdentificacion" => $_POST["tipoIdentificacion"],
        "nIdentificacion" => $_POST["nIdentificacion"],
        "usuario" => $_POST["usuario"],
        "clave" => $_POST["clave_"],
        "direccion" => $_POST["direccion"],
        "correo" => $_POST["correo"]
    );
}

function actualizarContra()
{
    //incluyendo la conexion a bd
    include "../config/conexion.php";
    // Obtener parámetros del formulario
    $data = obtenerClave();
    $pass = $encriptar($data["claveAct"]);
    $email = $_SESSION['email'];
    $stm = $conexion->prepare(SELECCIONAR_USUARIO);
    $stm->bind_param("s", $email);

    if (!$stm->execute()) {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Error al obtener el usuario"]);
        return;
    } else {
        $usuario = $stm->get_result()->fetch_assoc();
    }
    $stm = $conexion->prepare(ACTUALIZAR_CLAVE);
    $stm->bind_param("si", $pass, $usuario['usuario']);

    if ($stm->execute()) {

        session_unset();
        session_destroy();
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Clave actualizada con exito"]);
        return;
    }



}
function comprobarCodigo()
{
    //incluyendo la conexion a bd
    include "../config/conexion.php";
    // Obtener parámetros del formulario
    $data = obtenerCodigo();
    $codigo = $_SESSION['codigo'];

    if ($codigo == $data['codigo']) {

        // El usuario ya existe
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Codigo comfirmado codigo....."]);
        return;
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Codigo invalido"]);
        return;

    }
}
function buscarCorreo()
{
    //incluyendo la conexion a bd
    include "../config/conexion.php";

    // Obtener parámetros del formulario
    $data = obtenerParametrouser();
    $stm = $conexion->prepare(VERIFICAR_CORREO_EXISTE);
    $stm->bind_param("s", $data["correor"]);
    $stm->execute();
    $stm->store_result();

    if ($stm->num_rows > 0) {

        $stm->bind_result($usuario);
        $stm->fetch();
        enviar($usuario);
        $_SESSION['email'] = $data["correor"];
        // El usuario ya existe
        header('Content-Type: application/json');
        echo json_encode(["success" => true, "message" => "Correo encontrado enviando codigo....."]);
        return;
    } else {
        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Correo no encontrado"]);
        return;

    }
}
function enviar($usuario)
{
    $codigo = generarCodigo();
    $_SESSION['codigo'] = $codigo;

    $origenNombre = 'Bank'; // Nombre que visualiza el receptor del email como "origen" del email (es quien envía el email)
    $origenEmail = 'vaquerano222@gmail.com'; // Email que visualiza el receptor del email como "origen" del email (es quien envía el email)
    $destinatarioEmail = $_POST['correor']; // Destinatario del email, es decir, a quien le estamos enviando el email
    $uid = md5(uniqid(time())); // Fabrico un ID único que usaré para el "boundary"

    $asuntoEmail = 'Recuperación de Contraseña'; // Asunto del email

    // Nueva URL del logo
    $logoUrl = 'https://logos-world.net/wp-content/uploads/2021/03/Commerzbank-Logo.png';

    // Cuerpo del email en formato HTML
    $cuerpoMensaje = "
        <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        max-width: 600px;
                        margin: 20px auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    h1 {
                        color: #333;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                        display: block;
                        margin: 10px auto; /* Ajustado el margen */
                    }
                    p {
                        color: #555;
                    }
                    .code {
                        font-size: 24px;
                        color: #007bff;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <img src='$logoUrl' alt='Bank Logo' style='max-width: 150px;'> <!-- Logo más pequeño -->
                    <h1>Hola $usuario,</h1>
                    <p>Reciba un cordial saludo. Hemos recibido una solicitud para restablecer su contraseña.</p>
                    <p>A continuación, le proporcionamos un código de verificación:</p>
                    <div class='code'>$codigo</div>
                    <p>Utilice este código para completar el proceso de recuperación de contraseña.</p>
                </div>
            </body>
        </html>
    ";

    // Cabecera del email (forma correcta de codificarla)
    $header = "From: " . $origenNombre . " <" . $origenEmail . ">\r\n";
    $header .= "Reply-To: " . $origenEmail . "\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: text/html; charset=utf-8\r\n";

    // Envío el email y verifico la respuesta de la función "mail" (true o false)
    if (mail($destinatarioEmail, $asuntoEmail, $cuerpoMensaje, $header)) {
        // echo 'El código fue enviado correctamente';
    } else {
        // echo 'Error, no se pudo enviar el email';
    }
}
function generarCodigo()
{
    // Generar un número aleatorio de 100000 a 999999
    $codigo = rand(100000, 999999);

    return $codigo;
}
function iniciarSesion()
{
    include "../config/conexion.php";

    //session_start();

    $username = $_REQUEST["username"];
    $password = $encriptar($_REQUEST["clave"]);


    $stm = $conexion->prepare(COMPROBAR_USUARIOEMP);
    $stm->bind_param("ss", $username, $password);

    if ($stm->execute()) {
        $data = $stm->get_result();


        if ($data->num_rows > 0) {
            $data = $data->fetch_assoc();

            $_SESSION["user"] = $data["usuario"];
            $_SESSION["rol"] = ($data["rol"] === 1) ? "Admin" : "Empleado";
            header('Content-Type: application/json');
            echo json_encode(["success" => true, "message" => "Bienvenido"]);
            return;

        } else {
            $stm = $conexion->prepare(COMPROBAR_USUARIOSOC);
            $stm->bind_param("ss", $username, $password);

            if ($stm->execute()) {
                $data = $stm->get_result();
                if ($data->num_rows > 0) {
                    $data = $data->fetch_assoc();

                    $_SESSION["user"] = $data["usuario"];
                    $_SESSION["rol"] = "Socio";
                    $_SESSION["codeUser"] = $data["id"];
                    header('Content-Type: application/json');
                    echo json_encode(["success" => true, "message" => "Bienvenido", "usuario" => $data['usuario']]);
                    return;

                } else {
                    header('Content-Type: application/json');
                    echo json_encode(["success" => false, "message" => "Credenciales erróneas"]);
                    return;
                }

            }
        }

    } else {

        header('Content-Type: application/json');
        echo json_encode(["success" => false, "message" => "Error desconocido"]);
        return;
    }
}

function eliminarUsuario()
{
    include "../config/conexion.php";
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
function listarUsuarios()
{
    include "../config/conexion.php";
    $stm = $conexion->query(SELECCIONAR_TOODS_EMPLEADOS);
    if ($stm) {
        return $stm->fetch_all();
    }
    return null;
}



function editarUsuario()
{
    include "../config/conexion.php";


    // Obtener la contraseña y el id
    $pass = $encriptar($_POST["pass"]);
    $id = $_POST["id"];
    $usuario = $_SESSION["user"];
    $claveNueva = $_POST["clavenueva"];

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
            if ($claveNueva == "true") {
                // Actualizar clave de usuario
                $contra = $encriptar($data["claveNueva1"]);
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
    // Ingresar usuario
    $idUsuario = 0;
    $pass = $encriptar($data["clave"]);
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
function obtenerParametros()
{
    return array(
        "nombre" => $_POST["nombres"],
        "apellido" => $_POST["apellidos"],
        "tIdentificacion" => $_POST["tipoIdentificacion"],
        "nIdentificacion" => $_POST["nIdentificacion"],
        "usuario" => $_POST["usuario"],
        "clave" => $_POST["clave"],
        "clave2" => $_POST["clave2"],
        "usuario_privilegio" => $_POST["usuario_privilegio"],
        "claveNueva1" => $_POST["usuario_clave_nueva_1"],
        "claveNueva2" => $_POST["usuario_clave_nueva_2"]
    );
}
function obtenerParametrouser()
{
    return array(
        "correor" => $_POST["correor"]
    );
}

function obtenerCodigo()
{
    return array(
        "codigo" => $_POST["codigo"]
    );
}

function obtenerClave()
{
    return array(
        "claveAct2" => $_POST["claveAct2"],
        "claveAct" => $_POST["claveAct"]
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
