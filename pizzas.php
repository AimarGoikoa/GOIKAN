<?php
include "cabecera.php";
require_once "database/database.php"; // Asegúrate de incluir la conexión a la BD

// Consulta para obtener las pizzas y sus imágenes
$sql = "SELECT p.ID, p.post_title, img.guid AS image_url 
        FROM wp_posts p 
        JOIN wp_postmeta pm ON p.ID = pm.post_id 
        JOIN wp_posts img ON pm.meta_value = img.ID
        WHERE p.post_type = 'product' AND pm.meta_key = '_thumbnail_id'";

$resul = mysqli_query($conexion, $sql);

if (!$resul) {
    echo "<p>Error en consulta: " . mysqli_error($conexion) . "</p>";
} else {
    $pizzas = array();
    while ($fila = mysqli_fetch_assoc($resul)) {
        $pizzas[] = $fila;
    }
}

// Verificar si hay pizzas
if (empty($pizzas)) {
    echo "<p>No se encontraron pizzas en la base de datos.</p>";
} else {
    echo '<div class="galeria">';
    foreach ($pizzas as $pizza) {
        echo '<div class="imagenes">
                <img src="' . htmlspecialchars($pizza['image_url']) . '" alt="' . htmlspecialchars($pizza['post_title']) . '" width="350" height="200">
                <div class="desc">' . htmlspecialchars($pizza['post_title']) . '</div>
              </div>';
    }
    echo '</div>';
}

include "pie.php";
?>
