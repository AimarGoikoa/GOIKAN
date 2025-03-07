<?php
include "cabecera.php";
require_once "database/database.php"; // Asegurar conexión con la BD

$mensajeEnviado = false; // Variable para controlar el mensaje de éxito
$errores = array();

// Procesar formulario si se envía con POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $direccion = trim($_POST["direccion"]);
    $telefono = trim($_POST["tlfn"]);
    $email = trim($_POST["email"]);
    $mensaje = trim($_POST["mensaje"]);

    // Validaciones
    if (empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $errores['nombre'] = "El nombre solo puede contener letras y espacios.";
    }
    if (empty($direccion)) {
        $errores['direccion'] = "La dirección no puede estar vacía.";
    }
    if (empty($telefono) || !preg_match("/^[0-9]{7,15}$/", $telefono)) {
        $errores['tlfn'] = "El teléfono debe tener entre 7 y 15 números.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "El email ingresado no es válido.";
    }
    if (empty($mensaje)) {
        $errores['mensaje'] = "El mensaje no puede estar vacío.";
    }

    // Si no hay errores, guardar en la base de datos
    if (empty($errores)) {
        $sql = "INSERT INTO contacto (nombre, direccion, tlfn, email, mensaje) 
                VALUES ('$nombre', '$direccion', '$telefono', '$email', '$mensaje')";
        
        if (mysqli_query($conexion, $sql)) {
            $mensajeEnviado = true; // Confirmar que se guardó el mensaje
        } else {
            echo "<p class='error'>Error al enviar el mensaje: " . mysqli_error($conexion) . "</p>";
        }
    }
}
?>

<style>
    body {
        margin: 0;
        padding: 0;
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
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }
    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }
    .form-group input, .form-group textarea {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-group input:focus, .form-group textarea:focus {
        outline: none;
        border-color: #2e7d32;
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
        text-align: center;
    }
    .btn:hover {
        background-color: burlywood;
        color: black;
    }
    a {
        text-decoration: none;
        color: green;
    }
    .log {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }
    .log img {
        max-width: 350px;
        max-height: 350px;
        width: auto;
        height: auto;
    }
    .error {
        color: red;    
    }
    .success {
        color: green;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
    }
</style>

<div class="container">
    <div class="image-section">
        <p>
            <img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno3.jpg" alt="imagen pizza">
        </p>
    </div>

    <div class="form-section">
        <h2>Contáctanos</h2>

        <?php if ($mensajeEnviado): ?>
            <p class="success">✅ ¡Mensaje enviado con éxito!</p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre completo</label>
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <span class="error"><?= $errores['nombre'] ?? '' ?></span>
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <span class="error"><?= $errores['direccion'] ?? '' ?></span>
            </div>

            <div class="form-group">
                <label for="tlfn">Teléfono</label>
                <input type="text" name="tlfn" placeholder="Teléfono de contacto" required>
                <span class="error"><?= $errores['tlfn'] ?? '' ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="ejemplo@gmail.com" required>
                <span class="error"><?= $errores['email'] ?? '' ?></span>
            </div>

            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea name="mensaje" rows="5" required></textarea>
                <span class="error"><?= $errores['mensaje'] ?? '' ?></span>
            </div>

            <input class="btn" type="submit" name="enviar" value="Enviar">
        </form>

        <div class="log">
            <a href="index.php"><img src="imagenes/goikan logo.png"></a>
        </div>
    </div>

    <div class="image-section">
        <p>
            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
            <img src="./imagenes/pizza.jpg" alt="imagen pizza">
        </p>
    </div>
</div>

<?php
include "pie.php";
mysqli_close($conexion);
?>
