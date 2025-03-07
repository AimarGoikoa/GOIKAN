<?php
include "cabecera.php";
require_once "database/database.php"; // Conexión a la BD

// Consulta para obtener SOLO las pizzas con su precio
$sql = "SELECT p.ID, p.post_title, img.guid AS image_url, pm_price.meta_value AS price 
        FROM wp_posts p 
        JOIN wp_term_relationships tr ON p.ID = tr.object_id
        JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN wp_terms t ON tt.term_id = t.term_id
        JOIN wp_postmeta pm ON p.ID = pm.post_id
        JOIN wp_posts img ON pm.meta_value = img.ID
        JOIN wp_postmeta pm_price ON p.ID = pm_price.post_id AND pm_price.meta_key = '_price'
        WHERE p.post_type = 'product' 
        AND pm.meta_key = '_thumbnail_id'
        AND tt.taxonomy = 'product_cat'
        AND t.name = 'Pizzas'";  // FILTRAMOS POR CATEGORÍA 'Pizzas'

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
                <div class="precio">Precio: ' . number_format($pizza['price'], 2) . ' €</div>
                
                <form method="POST" action="carrito.php">
                    <input type="hidden" name="id_producto" value="' . htmlspecialchars($pizza['ID']) . '">
                    <input type="hidden" name="nombre_producto" value="' . htmlspecialchars($pizza['post_title']) . '">
                    <input type="hidden" name="precio_producto" value="' . htmlspecialchars($pizza['price']) . '">
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
