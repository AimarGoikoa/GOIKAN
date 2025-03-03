<?php
require_once "database/database.php";

// Incluir cabecera
include "cabecera.php";

/*******************************
 * VARIABLES Y ERRORES 
 *******************************/
$errores = array();
$username = "";
$password = "";

// Si el formulario se envía por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recogemos usuario y contraseña
    if (isset($_POST["username"])) {
        $username = trim($_POST["username"]);
    }
    if (isset($_POST["password"])) {
        $password = trim($_POST["password"]);
    }

    // Validaciones básicas
    if ($username === "") {
        $errores[] = "El campo 'Nombre de Usuario' es obligatorio.";
    }
    if ($password === "") {
        $errores[] = "El campo 'Contraseña' es obligatorio.";
    }

    // Si no hay errores, buscamos en la BD
    if (count($errores) === 0) {
        $sql = "SELECT id_cliente, nombre_usuario, password 
                FROM clientes 
                WHERE nombre_usuario = '$username'";
        $res = mysqli_query($conexion, $sql);
        if (!$res) {
            $errores[] = "Error en la consulta: " . mysqli_error($conexion);
        } else {
            $fila = mysqli_fetch_assoc($res);
            if (!$fila) {
                // No hay usuario con ese nombre
                $errores[] = "El usuario no existe.";
            } else {
                // Verificamos la contraseña
                // (En producción usar password_verify y password_hash)
                if ($fila["password"] === $password) {
                    // Login correcto
                    $_SESSION["usuario_id"]   = $fila["id_cliente"];
                    $_SESSION["usuario_name"] = $fila["nombre_usuario"];

                    // Redirigir a pizzas (por ejemplo)
                    header("Location: index.php");
                    exit;
                } else {
                    $errores[] = "Contraseña incorrecta.";
                }
            }
            mysqli_free_result($res);
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
    /* Mensajes de error */
    .error {
        color: red;
        margin-bottom: 10px;
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
        <h2>Inicio de Sesión</h2>

        <!-- MOSTRAR ERRORES -->
        <?php
        if (count($errores) > 0) {
            echo "<div class='error'>";
            foreach ($errores as $err) {
                echo "<p>".htmlspecialchars($err)."</p>";
            }
            echo "</div>";
        }
        ?>

        <!-- FORMULARIO LOGIN -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" 
                       placeholder="Nombre de Usuario"
                       value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <label for="recuerdame">Recordar usuario</label>
            <input type="checkbox" id="recuerdame" name="recuerdame" /><br /><br />

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>

            <label for="recordar">Recordar contraseña</label>
            <input type="checkbox" id="recordar" name="recordar" /><br /><br />

            <button class="btn" type="submit">Iniciar Sesión</button><br /><br />
            <button class="btn"> 
                <a href="registro.php">¿No tienes cuenta? Regístrate</a>
            </button>
            <br /><br />

            <div class="log">
                <a href="index.php"><img src="imagenes/goikan logo.png"></a>
            </div>
        </form>
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
// Pie de página
include "pie.php";

// Cerrar conexión
mysqli_close($conexion);
?>
