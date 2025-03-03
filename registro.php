<?php
require_once "database/database.php";
// 3. Incluimos la cabecera (donde tienes tu menú, estilos, etc.)
include "cabecera.php";

/*********************************************************
 * VARIABLES PARA EL FORMULARIO Y ARRAY DE ERRORES
 *********************************************************/
$errores = array();

$nombreCompleto  = "";  // NOMBRE_COMPLETO
$nuevoUsuario    = "";  // NOMBRE_USUARIO
$dni             = "";
$direccion       = "";
$telefono        = "";
$email           = "";
$password        = "";
$confirmPassword = "";

// Procesar el formulario si viene vía POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recolectar sin usar ??
    if (isset($_POST["full-name"])) {
        $nombreCompleto = trim($_POST["full-name"]);
    }
    if (isset($_POST["nuevo_usuario"])) {
        $nuevoUsuario = trim($_POST["nuevo_usuario"]);
    }
    if (isset($_POST["dni"])) {
        $dni = trim($_POST["dni"]);
    }
    if (isset($_POST["direccion"])) {
        $direccion = trim($_POST["direccion"]);
    }
    if (isset($_POST["telefono"])) {
        $telefono = trim($_POST["telefono"]);
    }
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    }
    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
    }
    if (isset($_POST["confirm-password"])) {
        $confirmPassword = trim($_POST["confirm-password"]);
    }

    /*********************************************************
     * VALIDACIONES
     *********************************************************/
    // Campos obligatorios
    if ($nombreCompleto === "") {
        $errores[] = "El campo 'Nombre Completo' es obligatorio.";
    }
    if ($nuevoUsuario === "") {
        $errores[] = "El campo 'Nombre Usuario' es obligatorio.";
    }
    if ($dni === "") {
        $errores[] = "El campo 'DNI' es obligatorio.";
    }
    if ($direccion === "") {
        $errores[] = "El campo 'Dirección' es obligatorio.";
    }
    if ($telefono === "") {
        $errores[] = "El campo 'Teléfono' es obligatorio.";
    }
    if ($email === "") {
        $errores[] = "El campo 'Email' es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }
    if ($password === "") {
        $errores[] = "El campo 'Contraseña' es obligatorio.";
    }
    // Confirmación de contraseña
    if ($confirmPassword === "") {
        $errores[] = "Debes repetir la contraseña.";
    } elseif ($password !== $confirmPassword) {
        $errores[] = "Las contraseñas no coinciden.";
    }

    // Si no hay errores, insertamos en la tabla 'clientes'
    if (count($errores) === 0) {
        // Si no manejas fecha alta en el formulario, puedes usar la fecha actual
        $fechaAlta = date("Y-m-d");  // p.ej. 2025-05-20
        // Empleado = 0 si es un cliente normal (tinyint)
        $empleado = 0;

        // Nota: en producción se recomienda usar password_hash() en vez de guardar en texto plano
        $sqlInsert = "INSERT INTO clientes 
            (NOMBRE_COMPLETO, NOMBRE_USUARIO, DNI, DIRECCION, TELEFONO, EMAIL, PASSWORD, FECHA_ALTA, EMPLEADO)
            VALUES 
            ('$nombreCompleto', '$nuevoUsuario', '$dni', '$direccion', '$telefono', '$email', '$password', '$fechaAlta', $empleado)";

        $resultado = mysqli_query($conexion, $sqlInsert);
        if ($resultado) {
            // Insert correcto
            echo "<h2>¡Registro Exitoso!</h2>";
            echo "<p>Bienvenido, <strong>" . htmlspecialchars($nombreCompleto) . "</strong>. Tu usuario se ha registrado correctamente.</p>";
            
            // Aquí podrías redirigir:
            // header("Location: login.php");
            // exit;

            // Para no mostrar el formulario nuevamente, detenemos la ejecución:
            exit;
        } else {
            // Error al insertar
            $errores[] = "Error al guardar en la base de datos: " . mysqli_error($conexion);
        }
    }
}
?>

<!-- HTML / FORMULARIO (igual que tu ejemplo, pero con action="" y los values para que persista lo que el usuario escribió) -->

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
    .form-group input {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .form-group input:focus {
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
    .btn:hover a {
        color: black;
    }
    a {
        text-decoration: none;
        color: white;
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
    .registro {
        display: block; 
        text-align: center; 
        margin-bottom: 20px; 
        font-size: 24px; 
        font-weight: bold; 
        color: #2e7d32; 
    }
    .error {
        color: red;
        margin-bottom: 10px;
    }
</style>

<div class="container">
    <div class="image-section">
        <p>
            <img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/pizzaHorno3.jpg" alt="imagen pizza">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
        </p>
    </div>
    
    <div class="form-section">
        <span class="registro"><strong>Nuevo Registro</strong> </span> <br />

        <!-- Mostrar errores si los hay -->
        <?php
        if (count($errores) > 0) {
            echo "<div class='error'>";
            foreach ($errores as $err) {
                echo "<p>" . htmlspecialchars($err) . "</p>";
            }
            echo "</div>";
        }
        ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="full-name">Nombre Completo</label>
                <input type="text" id="full-name" name="full-name" 
                       placeholder="Nombre Completo"
                       value="<?php echo htmlspecialchars($nombreCompleto); ?>">
            </div>
            <div class="form-group">
                <label for="nuevo_usuario">Nombre Usuario</label>
                <input type="text" id="nuevo_usuario" name="nuevo_usuario" 
                       placeholder="Nombre Usuario"
                       value="<?php echo htmlspecialchars($nuevoUsuario); ?>">
            </div>
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" 
                       placeholder="DNI"
                       value="<?php echo htmlspecialchars($dni); ?>">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion"
                       placeholder="Dirección"
                       value="<?php echo htmlspecialchars($direccion); ?>">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" 
                       placeholder="Teléfono"
                       value="<?php echo htmlspecialchars($telefono); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" 
                       placeholder="Email"
                       value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" 
                       placeholder="Contraseña">
            </div>
            <div class="form-group">
                <label for="confirm-password">Repetir Contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password" 
                       placeholder="Repetir Contraseña">
            </div>
            <button type="submit" class="btn">Registrar</button>
        </form>
    </div>

    <div class="image-section">
        <p>
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/local2.jpg" alt="imagen pizza">
        </p>
    </div>
</div>

<?php
// Incluimos pie
include "pie.php";

// Cerramos la conexión
mysqli_close($conexion);
?>
