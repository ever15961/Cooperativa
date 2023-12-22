<?php 
$conexion = null;
try {
    $conexion = mysqli_connect("localhost", "root", "");
    $conexion->select_db("data_tpi");

   /*/ $stm = $conexion->prepare("");
    $stm->execute();
    $stm->bind_result()*/
} catch (PDOException $e) {
    $e->getMessage();
    exit();
}
include "mcript.php";
//$stm = $conexion->prepare();
