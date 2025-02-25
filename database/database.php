<?php

$bdConexion = "localhost";
$username = "root";
$passwd = "";
$baseDatos = "bdgoikan";

try {
    $conexion = @mysqli_connect($bdConexion,$username,$passwd);
    $result = @mysqli_select_db($conexion, $baseDatos);
    $mensaje = "conexion exitosa";
} catch (\Throwable $th) {
    $error = "Error: $th";
    include "error.php";
}
?>