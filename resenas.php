<?php
include "cabecera.php";
require_once "database/database.php"; // Conexión a la BD

$mensajeEnviado = false; // Mensaje de éxito
$errores = array();

// Procesar formulario si se envía con POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nota = trim($_POST["nota"]);
    $comentario = trim($_POST["comentario"]);
    $id_cliente = 1; // Se debe obtener dinámicamente en un sistema con usuarios

    // Validaciones
    if (!is_numeric($nota) || $nota < 1 || $nota > 5) {
        $errores['nota'] = "La nota debe estar entre 1 y 5.";
    }
    if (empty($comentario)) {
        $errores['comentario'] = "El comentario no puede estar vacío.";
    }

    // Si no hay errores, guardar en la base de datos
    if (empty($errores)) {
        $sql = "INSERT INTO resenas (NOTA, FECHA_HORA, COMENTARIO, ID_CLIENTE) 
                VALUES ('$nota', NOW(), '$comentario', '$id_cliente')";
        
        if (mysqli_query($conexion, $sql)) {
            $mensajeEnviado = true;
        } else {
            echo "<p class='error'>Error al enviar la reseña: " . mysqli_error($conexion) . "</p>";
        }
    }
}

// Obtener todas las reseñas para mostrar
$sqlResenas = "SELECT NOTA, FECHA_HORA, COMENTARIO FROM resenas ORDER BY FECHA_HORA DESC";
$resenas = mysqli_query($conexion, $sqlResenas);
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ccc;
    }
    .container {
        display: flex;
        width: 80%;
        max-width: 1200px;
        background: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        padding: 20px;
    }
    .image-section {
        flex: 1;
        background-color: #eaeaea;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .image-section img {
        max-width: 100%;
        max-height: 100%;
    }
    .form-section {
        flex: 2;
        padding: 20px;
    }
    .form-section h2 {
        margin-bottom: 20px;
        text-align: center;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-group input, .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .btn {
        padding: 10px;
        font-size: 16px;
        color: white;
        background-color: #2e7d32;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }
    .btn:hover {
        background-color: burlywood;
        color: black;
    }
    .error {
        color: red;
    }
    .success {
        color: green;
        font-weight: bold;
        text-align: center;
    }
    .resenas {
        margin-top: 20px;
    }
    .resena {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }
    .nota {
        font-weight: bold;
        color: #e67e22;
    }
</style>

<div class="container">
    <div class="image-section">
        <p>
            <img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno3.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
        </p>
    </div>

    <div class="form-section">
        <h2>Valoraciones</h2>

        <?php if ($mensajeEnviado): ?>
            <p class="success">✅ ¡Reseña enviada con éxito!</p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nota">Calificación (1-5)</label>
                <input type="number" id="nota" name="nota" min="1" max="5" required>
                <span class="error"><?= $errores['nota'] ?? '' ?></span>
            </div>

            <div class="form-group">
                <label for="comentario">Comentario</label>
                <textarea name="comentario" id="comentario" cols="30" rows="3" required></textarea>
                <span class="error"><?= $errores['comentario'] ?? '' ?></span>
            </div>

            <input class="btn" type="submit" name="enviar" value="Enviar Reseña">
        </form>

        <div class="resenas">
            <h3>Opiniones de Clientes</h3>
            <?php while ($resena = mysqli_fetch_assoc($resenas)): ?>
                <div class="resena">
                    <p class="nota">⭐ <?= htmlspecialchars($resena['NOTA']) ?> / 5</p>
                    <p><?= htmlspecialchars($resena['COMENTARIO']) ?></p>
                    <small><?= $resena['FECHA_HORA'] ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="image-section">
        <p>
            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
            <img src="./imagenes/pizza.jpg" alt="imagen pizza">
            <img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
        </p>
    </div>
</div>

<?php
include "pie.php";
mysqli_close($conexion);
?>
