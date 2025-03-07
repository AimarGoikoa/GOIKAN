<?php
include "cabecera.php";
require_once "database/database.php"; // Asegurar conexión con la BD
$sql = "SELECT p.ID, p.post_title, img.guid AS image_url, MAX(pm_price.meta_value) AS price 
        FROM wp_posts p 
        JOIN wp_postmeta pm ON p.ID = pm.post_id 
        JOIN wp_posts img ON pm.meta_value = img.ID
        JOIN wp_postmeta pm_price ON p.ID = pm_price.post_id AND pm_price.meta_key = '_price'
        WHERE p.post_type = 'product' 
        AND (p.post_title LIKE '%Pizza%' OR p.post_title LIKE '%Nachos%') 
        AND pm.meta_key = '_thumbnail_id'
        GROUP BY p.ID, p.post_title, img.guid";

$resul = mysqli_query($conexion, $sql);

if (!$resul) {
    echo "<p>Error en consulta: " . mysqli_error($conexion) . "</p>";
} else {
    $productos = array();
    while ($fila = mysqli_fetch_assoc($resul)) {
        $productos[] = $fila;
    }
}

// Verificar si hay productos
if (empty($productos)) {
    echo "<p>No se encontraron productos en la base de datos.</p>";
} else {
    echo '<div class="galeria">';
    foreach ($productos as $producto) {
        echo '<div class="imagenes">
                <img src="' . htmlspecialchars($producto['image_url']) . '" alt="' . htmlspecialchars($producto['post_title']) . '" width="350" height="200">
                <div class="desc">' . htmlspecialchars($producto['post_title']) . '</div>
                <div class="precio">Precio: ' . number_format($producto['price'], 2) . ' €</div>

                <!-- Formulario para agregar al carrito -->
                <form method="POST" action="carrito.php">
                    <input type="hidden" name="id_producto" value="' . htmlspecialchars($producto['ID']) . '">
                    <input type="hidden" name="nombre_producto" value="' . htmlspecialchars($producto['post_title']) . '">
                    <input type="hidden" name="precio_producto" value="' . htmlspecialchars($producto['price']) . '">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" value="1" min="1">
                    <button type="submit">Añadir al carrito</button>
                </form>
              </div>';
    }
    echo '</div>';
}

include "pie.php";
?>

