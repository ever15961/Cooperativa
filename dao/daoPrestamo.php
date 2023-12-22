<?php 

include "util/sqlPrestamo.php";
//parametro de operacion a realizar
$op = isset($_REQUEST["operacion"]) ? $_REQUEST["operacion"] : "";

//verificando operación a realizar
elegirOperacion($op);

//verificar el tipo de operación a realizar (ingresar,modificar,entre otros)
function elegirOperacion($op)
{
    switch ($op) {
        case "ingresar":
            registrarPrestamo();
        break;

        case "editar" :
                editarSocio();
            break;

        case "eliminar":
                eliminarSocio();
            break;

        case "iniciarSesion":
                iniciarSesion();
            break;

        case "comprobarSocio":
                comprobarSocio();
            break;

            case "mostrar":
                mostrar();
            break;

        default :
            break;
    }
}

function mostrar(){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Verifica si "posicion" está presente en la solicitud
        if (isset($_POST["posicion"])) {
            // Obtén el valor de "posicion"
            $id = $_POST["posicion"];
            $listaCuota=mostrarcuotasp($id);
            // Construye un array con el ID
            $data = array('id' => $listaCuota);
    
            // Convierte el array a formato JSON y lo imprime
            echo json_encode($data);
        } else {
            // Si "posicion" no está presente en la solicitud, emite un mensaje de error
            echo json_encode(array('error' => 'Posicion no proporcionada'));
        }
    } else {
        // Si la solicitud no es POST, emite un mensaje de error
        echo json_encode(array('error' => 'Se esperaba una solicitud POST'));
    }
   }
function registrarPrestamo(){
    include "../config/conexion.php";
    include "util/sqlPrestamo.php";
    
    $data=obtenerParametros();

    
    $stm = $conexion->prepare(GUARDAR_PRESTAMOS);
    $stm->bind_param("didsiii", $data["monto"], $data["destino"],$data["tasaInteres"],$data["fechaInicio"],$data["socio"],$data["plazo_anio"],$data["plazo_cuota"]);

    if($stm->execute()){
        $stm = $conexion->query(SELECCIONAR_ULTIMO_PRESTAMO);
        if($stm){
            $data["id"] = $stm->fetch_row()[0];
        }
    }

    calcularYGuardarCuotasConFechas($data["id"],$data["monto"],$data["tasaInteres"],$data["plazo_anio"],$data["plazo_cuota"],$data["fechaInicio"]);


}

function listarCuotas(){
    include "../config/conexion.php";
    $stm = $conexion->query(TODS_CUOTAS);
    if($stm){
        return $stm->fetch_all();
    }
    return null;
}

function mostrarcuotasp($id){
    include "../config/conexion.php";
    
    // Utiliza la declaración preparada para prevenir inyecciones SQL
    $sql = TODS_CUOTAS_PRES;
    $stmt = $conexion->prepare($sql);

    // Verifica si la preparación fue exitosa
    if ($stmt) {
        // Vincula el parámetro usando bind_param
        $stmt->bind_param("i", $id);

        // Ejecuta la consulta
        $stmt->execute();

        // Obtiene el resultado
        $result = $stmt->get_result();

        // Obtiene todas las filas como un array asociativo
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        // Cierra la declaración
        $stmt->close();

        // Devuelve los resultados
        return $rows;
    } else {
        // Manejo de error si la preparación falla
        return null;
    }
}

function calcularYGuardarCuotasConFechas($idPrestamo,$montoPrestamo, $tasaInteresAnual, $plazoAnios, $frecuenciaPago, $fechaInicio) {
    // ... (código para la conexión a la base de datos)
    include "../config/conexion.php";
    include "util/sqlPrestamo.php";


    // Convertir la fecha de inicio a objeto DateTime
    $fechaVencimiento = new DateTime($fechaInicio);

    // Convertir el plazo de años a meses
    $plazoMeses = $plazoAnios * 12;

    // Calcular la tasa de interés mensual
    $tasaInteresMensual = $tasaInteresAnual / 12 / 100;
if($frecuenciaPago==1){
    $frecuencia="mensual";
}else if($frecuenciaPago==2){
$frecuencia="trimestral";
}else{
    $frecuencia="semestral";
}


// Calcular la cuota mensual sin ajustes
$cuotaMensual = ($montoPrestamo * $tasaInteresMensual) / (1 - pow(1 + $tasaInteresMensual, -$plazoMeses));


// Ajustar la cuota según la frecuencia de pago
if ($frecuencia === "trimestral") {
    $cuotaMensual = $cuotaMensual * 3;  // Multiplicar la cuota por 3 para ajustar a pagos trimestrales
} elseif ($frecuencia === "semestral") {
    $cuotaMensual = $cuotaMensual * 6;  // Multiplicar la cuota por 6 para ajustar a pagos semestrales
}

    // Preparar la consulta para insertar cuotas

    $stmtInsertarCuota = $conexion->prepare(GUARDAR_CUOTAS);
    $stmtInsertarCuota->bind_param("iidsddd", $idPrestamo, $numeroCuota, $cuota,$fechaVencimientoStr, $interes, $principal, $saldoPendiente);
    $saldoPendiente= $montoPrestamo;
    // Calcular y guardar las cuotas mensuales
    for ($i = 1; $i <= $plazoMeses; $i++) {
    // Calcular el interés para este período
    if ($frecuencia === "mensual" || ($frecuencia === "trimestral" && $i % 3 === 0) || ($frecuencia === "semestral" && $i % 6 === 0)) {
        $interes = $saldoPendiente * $tasaInteresMensual;

        // Ajustar el interés si es trimestral
        if ($frecuencia === "trimestral" && $i % 3 === 0) {
            $interes *= 3;  // Multiplicar el interés por 3 para ajustar a pagos trimestrales
        } elseif ($frecuencia === "semestral" && $i % 6 === 0) {
            $interes *= 6;  // Multiplicar el interés por 6 para ajustar a pagos semestrales
        }

        // Calcular el principal para este período
        $principal = $cuotaMensual - $interes;

        // Ajustar el principal si es la última cuota
        if ($i == $plazoMeses) {
            $principal = max($saldoPendiente, 0); // Asegurarse de que el principal no sea negativo
        }

        // Actualizar el saldo pendiente
        $saldoPendiente -= $principal;

        // Almacenar la cuota en la base de datos
        $numeroCuota ++;
        $cuota = $cuotaMensual;
        $fechaVencimientoStr = $fechaVencimiento->format('Y-m-d');
        $stmtInsertarCuota->execute();
    }

    // Añadir la frecuencia de pago a la fecha de vencimiento
    if ($frecuencia === "mensual") {
        $fechaVencimiento->add(new DateInterval("P1M"));
    } elseif ($frecuencia === "trimestral" && $i % 3 === 0) {
        $fechaVencimiento->add(new DateInterval("P3M"));
    } elseif ($frecuencia === "semestral" && $i % 6 === 0) {
        $fechaVencimiento->add(new DateInterval("P6M"));
    }
    
}}


function comprobarSocio(){
    include "../config/conexion.php";
    include "util/sqlPrestamo.php";

    $stm = $conexion->prepare(OBTENER_COINCIDENCIAS);

    $dato = $_REQUEST["dato"];
    
    $stm->bind_param("sssss",$dato,$dato,$dato,$dato,$dato);

    if($stm->execute()){
        $data = $stm->get_result();
        var_dump($data->fetch_assoc());
    }

}


function eliminarSocio(){
    include "../config/conexion.php";

    $socio = 0;

    $stm = $conexion->prepare(SELECCIONAR_SOCIO);
    $stm->bind_param("i",$_POST["posicion"]);

    if($stm->execute()){
        $socio = (($stm->get_result())->fetch_assoc())["id"];
    }
    
    $stm = $conexion->prepare(ELIMINAR_SOCIO);
    $stm->bind_param("i",$socio);

    if($stm->execute()){
        echo json_encode("Socio eliminado correctamente!");
        return;
    }
    echo json_encode();
}



//función para obtener lista de socios
function listarPrestamos(){
    include "../config/conexion.php";
    $stm = $conexion->query(OBTENER_TODOS_PRESTAMOS);
    if($stm){
        return $stm->fetch_all();
    }
    return null;
}



function editarSocio(){
    include "../config/conexion.php";

    $posicion = $_POST["posicion"];

    $socio = 0;
    $identificacion = 0;

    $data = obtenerParametros();

    $stm = $conexion->prepare(OBTENER_CLAVES_PRIMARIAS);
    $stm->bind_param("i",$_POST["posicion"]);

    if($stm->execute()){
       $result = $stm->get_result();
       $array  = $result->fetch_assoc();

       $socio = $array["socio"];
       $identificacion = $array["identificacion"];
    }

    $stm = $conexion->prepare(ACTUALIZAR_SOCIO);
    $stm->bind_param("ssssi",$data["nombre"],$data["apellido"],$data["direccion"],$data["telefono"],$socio);

    if($stm->execute()){
        echo json_encode("Modificado con exito");
    }

    $stm = $conexion->prepare(ACTUALIZAR_IDENTIFICACION);
    $stm->bind_param("ssi",$data["nIdentificacion"],$data["tIdentificacion"],$identificacion);

    if($stm->execute()){
        echo json_encode("Modificado con exito");
    }
    
}

//función que ingresa el socio a la bd
function ingresarSocio()
{
    //incluyendo la conexion a bd
    include "../config/conexion.php";

    //obtener parametros de formulario
    $data = obtenerParametros();

    #ingresando data a bd

    //ingresar usuario
    $idUsuario = 0;

    $stm = $conexion->prepare(INGRESAR_USUARIO);
    $stm->bind_param("ss",$data["usuario"],$data["clave"]);

    if($stm->execute()){
        $stm = $conexion->query(SELECCIONAR_ULTIMO_USUARIO);
        if($stm){
            $data["idUsuario"] = $stm->fetch_row()[0];
        }
    }

    #ingresar identificacion
    $idIdentificacion = 0;
    $stm = $conexion->prepare(INGRESAR_IDENTIFICACION);
    $stm->bind_param("si",$data["nIdentificacion"],$data["tIdentificacion"]);
    if($stm->execute()){
        $stm = $conexion->query(SELECCIONAR_ULTIMA_IDENTIFICACION);
        if($stm){
            $data["nIdentificacion"] = $stm->fetch_row()[0];
        }
    }
  

    $vacio = "";
    #ingresando socio 
    $stm = $conexion->prepare(INGRESAR_SOCIO);
   
        $stm->bind_param("ssisssi",$data["nombre"],$data["apellido"],$data["nIdentificacion"],
                               $data["direccion"],$data["telefono"],$vacio,$data["idUsuario"]);

    if($stm->execute()){
        echo json_encode("Registro ingresado!");
    }

}

//obtiene parametros de formulario mediante POST
function obtenerParametros(){
    return array(
                    "monto"          =>  $_POST["monto"],
                    "destino"        =>  $_POST["destino"],
                    "tasaInteres"       =>  $_POST["interes"],
                    "fechaInicio"        =>  $_POST["fInicio"],
                    "socio" =>  $_POST["socio"],
                    "plazo_anio" =>  $_POST["plazo"],
                    "plazo_cuota"           =>  $_POST["plazocuota"]
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
