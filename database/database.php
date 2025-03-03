<?php
session_start(); // Manejo de sesión (carrito, login, etc.)
$bdConexion = "localhost:3307";
$username = "root";
$passwd = "1234";
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