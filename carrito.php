<?php
session_start();

// Si no existe el carrito, lo creamos
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Verifica si se recibe un producto desde el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $precio_producto = $_POST['precio_producto'];
    $cantidad = $_POST['cantidad'];

    // Verifica si ya existe el producto en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$id_producto] = array(
            "nombre" => $nombre_producto,
            "precio" => $precio_producto,
            "cantidad" => $cantidad
        );
    }
}

// Redirigir al resumen del carrito
header("Location: resumen.php");
exit();
?>
