<?php
require_once "database/database.php";
include "cabecera.php";

// Iniciar sesión para el manejo del carrito
if (!isset($_SESSION)) {
    session_start();
}

// Si no existe el carrito en la sesión, lo creamos vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

$carrito = $_SESSION['carrito'];
$total = 0;

// ==============================================
// 🔹 PARTE B: PROCESAR FORMULARIO
// ==============================================
$errores = array();
$exito = false;

// Procesar el formulario solo si se envió con POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : "";
    $entrega = isset($_POST["entrega"]) ? $_POST["entrega"] : "";

    // Validaciones:
    if (empty($nombre) || !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $errores[] = "El campo 'Nombre Completo' es obligatorio y solo puede contener letras y espacios.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email ingresado no es válido.";
    }
    if (empty($telefono) || !preg_match("/^[0-9]{7,15}$/", $telefono)) {
        $errores[] = "El teléfono debe contener solo números (7 a 15 dígitos).";
    }
    if (!in_array($entrega, ["Recoger", "Domicilio", "Local"])) {
        $errores[] = "Debes seleccionar un método de entrega válido.";
    }

    // Si no hay errores, guardamos en la BD
    if (empty($errores)) {
        mysqli_begin_transaction($conexion);
        // Buscar si el cliente ya existe en la tabla 'clientes' por su email
$sqlCliente = "SELECT ID_CLIENTE FROM clientes WHERE EMAIL = '$email'";
$resCliente = mysqli_query($conexion, $sqlCliente);

if ($resCliente && mysqli_num_rows($resCliente) > 0) {
    // Si el cliente existe, obtenemos su ID
    $filaCliente = mysqli_fetch_assoc($resCliente);
    $idCliente = $filaCliente['ID_CLIENTE'];
} else {
    // Si el cliente no existe, lo insertamos
    $sqlInsertCliente = "INSERT INTO clientes (NOMBRE_COMPLETO, EMAIL) VALUES ('$nombre', '$email')";
    $okCliente = mysqli_query($conexion, $sqlInsertCliente);
    
    if ($okCliente) {
        $idCliente = mysqli_insert_id($conexion); // Obtener el ID recién insertado
    } else {
        $errores[] = "Error al insertar cliente: " . mysqli_error($conexion);
        mysqli_rollback($conexion);
    }
}


        $fechaActual = date("Y-m-d H:i:s");
        $empleado_id = 1; // ID de un empleado existente en la base de datos
        $sqlPedido = "INSERT INTO pedidos (TIPO, FECHA_HORA, ID_CLIENTE) 
              VALUES ('$entrega', NOW(), '$idCliente')";



$okPedido = mysqli_query($conexion, $sqlPedido);

if (!$okPedido) {
    $errores[] = "Error al guardar el pedido: " . mysqli_error($conexion);
    mysqli_rollback($conexion);
} else {
    // Si la inserción en 'pedidos' fue exitosa, tomamos el ID del pedido recién insertado
    $pedidoId = mysqli_insert_id($conexion);
}
$huboErrorDetalle = false;

            foreach ($_SESSION['carrito'] as $idProd => $producto) {
                $sqlDet = "INSERT INTO pedidos_detalle (pedido_id, producto_id, cantidad, precio_unitario)
                           VALUES ($pedidoId, $idProd, {$producto['cantidad']}, {$producto['precio']})";

                if (!mysqli_query($conexion, $sqlDet)) {
                    $errores[] = "Error al guardar el detalle del pedido: " . mysqli_error($conexion);
                    $huboErrorDetalle = true;
                    break;
                }
            }

            if (!$huboErrorDetalle) {
                mysqli_commit($conexion);
                $_SESSION['carrito'] = array(); // Vaciar el carrito
                $exito = true;
            } else {
                mysqli_rollback($conexion);
            }
        }
    }

?>

<div class="contenedor">
    <h2>Resumen de Pedido</h2>

    <?php if ($exito): ?>
        <h2>¡Pedido Realizado con Éxito!</h2>
        <p>Gracias, <strong><?= htmlspecialchars($nombre) ?></strong>. Tu pedido ha sido procesado correctamente.</p>
        <p><a href="index.php">Volver al inicio</a></p>
    <?php else: ?>
        <?php if (empty($carrito)): ?>
            <p>El carrito está vacío.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $id => $producto): ?>
                        <?php $subtotal = $producto['precio'] * $producto['cantidad']; $total += $subtotal; ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td><?= $producto['cantidad'] ?></td>
                            <td><?= number_format($producto['precio'], 2, ',', '.') ?> €</td>
                            <td><?= number_format($subtotal, 2, ',', '.') ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total a pagar: <?= number_format($total, 2, ',', '.') ?> €</h3>
        <?php endif; ?>

        <!-- Formulario de Cliente -->
        <h2>Datos del Cliente</h2>
        <?php if (!empty($errores)): ?>
            <div class="error">
                <?php foreach ($errores as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <p>Nombre Completo:</p>
            <input type="text" name="nombre" required style="width:100%; padding:8px;">

            <p>Email:</p>
            <input type="email" name="email" required style="width:100%; padding:8px;">

            <p>Teléfono:</p>
            <input type="text" name="telefono" required pattern="[0-9]{7,15}" title="Solo números, entre 7 y 15 caracteres" style="width:100%; padding:8px;">

            <p>Modo de Entrega:</p>
            <label><input type="radio" name="entrega" value="Recoger" required> Recoger</label><br>
            <label><input type="radio" name="entrega" value="Domicilio"> Domicilio</label><br>
            <label><input type="radio" name="entrega" value="Local"> Local</label><br><br>

            <button type="submit" class="boton">FINALIZAR PEDIDO</button>
        </form>
    <?php endif; ?>
</div>

<?php
include "pie.php";
mysqli_close($conexion);
?>


<!-- ESTILOS BÁSICOS (puedes moverlos a tu CSS) -->
<style>
.contenedor {
    width: 600px;
    margin: 20px auto;
    background: #fff;
    padding: 25px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0,0,0,0.3);
}
.error {
    color: red;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
table th, table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: center;
}
.boton {
    display: block;
    width: 100%;
    padding: 10px;
    background: #2e7d32;
    color: #fff;
    border: none;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
}
.boton:hover {
    background: burlywood;
    color: #000;
}
</style>


