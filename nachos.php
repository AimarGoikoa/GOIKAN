<?php
include "cabecera.php";
require_once "database/database.php"; // Conexión a la base de datos

// Consulta para obtener los nachos con sus imágenes y precios
$sql = "SELECT p.ID, p.post_title, pm.meta_value AS image_id, img.guid AS image_url, meta_price.meta_value AS price 
        FROM wp_posts p 
        JOIN wp_term_relationships tr ON p.ID = tr.object_id
        JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN wp_terms t ON tt.term_id = t.term_id
        LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
        LEFT JOIN wp_posts img ON pm.meta_value = img.ID
        LEFT JOIN wp_postmeta meta_price ON p.ID = meta_price.post_id AND meta_price.meta_key = '_price'
        WHERE p.post_type = 'product' AND tt.taxonomy = 'product_cat' AND t.name = 'Nachos'";

$resul = mysqli_query($conexion, $sql);
$nachos = [];

if ($resul) {
    while ($fila = mysqli_fetch_assoc($resul)) {
        $nachos[] = $fila;
    }
}
?>

<div class="galeria">
    <?php if (!empty($nachos)) : ?>
        <?php foreach ($nachos as $nacho) : ?>
            <div class="imagenes">
            <img src="<?= $nacho['image_url']; ?>" alt="<?= $nacho['post_title']; ?>">
            <div class="desc"><?= $nacho['post_title']; ?></div>
            <div class="precio">Precio: <?= number_format((float)$nacho['price'], 2, ',', '.'); ?> €</div>

            <form method="POST" action="carrito.php">
                <input type="hidden" name="id_producto" value="<?= $nacho['ID']; ?>">
                <input type="hidden" name="nombre_producto" value="<?= $nacho['post_title']; ?>">
                <input type="hidden" name="precio_producto" value="<?= $nacho['price']; ?>">
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad" value="1" min="1">
                <button type="submit">Añadir al carrito</button>
            </form>
        </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No hay nachos disponibles.</p>
    <?php endif; ?>
</div>

<?php
include "pie.php";
?>
