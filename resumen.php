<?php

require_once "database/database.php";

include "cabecera.php";

/*******************************************************
 * PARTE A: MOSTRAR CARRITO
 *******************************************************/
// Si no existe el carrito en la sesión, lo creamos vacío
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Recuperamos la información de los productos del carrito
$productosCarrito = array();
$total = 0;

if (!empty($_SESSION['carrito'])) {
    // Obtenemos las claves (IDs) de los productos
    $idsCarrito = array_keys($_SESSION['carrito']);  // [1, 2, 3] por ejemplo
    $listaIds    = implode(",", $idsCarrito);        // "1,2,3"

    // Consulta en la tabla 'productos'
    // Ajusta los campos (nombre, precio, etc.) a los tuyos
    $sqlProd = "SELECT id, nombre, precio FROM productos WHERE id IN ($listaIds)";
    $resProd = mysqli_query($conexion, $sqlProd);
    
    if ($resProd) {
        while ($fila = mysqli_fetch_assoc($resProd)) {
            $productosCarrito[] = $fila;
        }
        mysqli_free_result($resProd);
    }
}

// 3. Variables para el formulario
$nombre   = "";
$email    = "";
$telefono = "";
$entrega  = "";  // Recoger, Domicilio o Local
$errores  = array();
$exito    = false;

/*******************************************************
 * PARTE B: PROCESAR FORMULARIO (MISMA PÁGINA)
 *******************************************************/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recolectamos datos sin ?? (usamos isset)
    if (isset($_POST["nombre"])) {
        $nombre = trim($_POST["nombre"]);
    } else {
        $nombre = "";
    }

    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    } else {
        $email = "";
    }

    if (isset($_POST["telefono"])) {
        $telefono = trim($_POST["telefono"]);
    } else {
        $telefono = "";
    }

    if (isset($_POST["entrega"])) {
        $entrega = $_POST["entrega"];
    } else {
        $entrega = "";
    }

    // Validaciones:
    // 1) Nombre
    if ($nombre === "") {
        $errores[] = "El campo 'Nombre Completo' es obligatorio.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre)) {
        $errores[] = "El nombre solo puede contener letras y espacios.";
    }

    // 2) Email
    if ($email === "") {
        $errores[] = "El campo 'Email' es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del email no es válido.";
    }

    // 3) Teléfono
    if ($telefono === "") {
        $errores[] = "El campo 'Teléfono' es obligatorio.";
    } elseif (!preg_match("/^[0-9]{7,15}$/", $telefono)) {
        $errores[] = "El teléfono debe contener solo dígitos (7 a 15).";
    }

    // 4) Opción de entrega
    if ($entrega !== "Recoger" && $entrega !== "Domicilio" && $entrega !== "Local") {
        $errores[] = "Debes seleccionar 'Recoger', 'Domicilio' o 'Local'.";
    }

    // Si no hay errores, insertamos en la BD (pedidos + pedidos_detalle)
    if (count($errores) === 0) {
        // Empezar transacción manual
        mysqli_begin_transaction($conexion);

        // Insertar en 'pedidos'
        // Asumimos que tu tabla 'pedidos' tiene:
        // id, cliente_nombre, cliente_email, cliente_telefono, modo_entrega, fecha
        $fechaActual = date("Y-m-d H:i:s");
        $sqlPedido = "INSERT INTO pedidos (cliente_nombre, cliente_email, cliente_telefono, modo_entrega, fecha)
                      VALUES ('$nombre', '$email', '$telefono', '$entrega', '$fechaActual')";
        $okPedido = mysqli_query($conexion, $sqlPedido);

        if (!$okPedido) {
            // Error en INSERT pedido
            $errores[] = "Error al guardar el pedido: " . mysqli_error($conexion);
            mysqli_rollback($conexion);
        } else {
            // Tomar el id del pedido
            $pedidoId = mysqli_insert_id($conexion);

            $huboErrorDetalle = false;
            // Insertar cada producto del carrito en pedidos_detalle
            foreach ($_SESSION['carrito'] as $idProd => $cant) {
                // Obtener su precio actual para guardarlo en detalle
                $sqlPrecio = "SELECT precio FROM productos WHERE id = $idProd";
                $resPrecio = mysqli_query($conexion, $sqlPrecio);
                if ($resPrecio) {
                    $filaPrecio = mysqli_fetch_assoc($resPrecio);
                    mysqli_free_result($resPrecio);

                    if ($filaPrecio) {
                        $precioUnit = $filaPrecio["precio"];
                        $sqlDet = "INSERT INTO pedidos_detalle (pedido_id, producto_id, cantidad, precio_unitario)
                                   VALUES ($pedidoId, $idProd, $cant, $precioUnit)";

                        $okDet = mysqli_query($conexion, $sqlDet);
                        if (!$okDet) {
                            $errores[] = "Error al insertar detalle de pedido: " . mysqli_error($conexion);
                            $huboErrorDetalle = true;
                            break;
                        }
                    }
                } else {
                    $errores[] = "Error en consulta de precio: " . mysqli_error($conexion);
                    $huboErrorDetalle = true;
                    break;
                }
            }

            // Si no hubo error en el detalle, confirmamos
            if (!$huboErrorDetalle) {
                mysqli_commit($conexion);
                // Vaciar carrito
                $_SESSION['carrito'] = array();
                // Marcar éxito
                $exito = true;
            } else {
                mysqli_rollback($conexion);
            }
        }
    }
}
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

<div class="contenedor">

<?php
/*******************************************************
 * PARTE C: MOSTRAR RESUMEN, FORMULARIO O ÉXITO
 *******************************************************/
if ($exito) {
    // Pedido confirmado
    echo "<h2>¡Pedido Realizado con Éxito!</h2>";
    echo "<p>Gracias, <strong>".htmlspecialchars($nombre)."</strong>. Tu pedido se ha guardado correctamente.</p>";
    echo "<p><a href='index.php'>Volver al inicio</a></p>";
} else {
    // Mostramos el resumen del carrito
    echo "<h2>Resumen de Pedido</h2>";
    if (empty($_SESSION['carrito'])) {
        echo "<p>El carrito está vacío.</p>";
    } else {
        echo "<table>";
        echo "<thead><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr></thead>";
        echo "<tbody>";

        // OJO: $productosCarrito ya lo usamos antes
        // recreamos o iteramos de nuevo
        $resProd2 = mysqli_query($conexion, "SELECT id, nombre, precio FROM productos WHERE id IN (".implode(",", array_keys($_SESSION['carrito'])).")");
        $total = 0;
        if ($resProd2) {
            while ($rowP = mysqli_fetch_assoc($resProd2)) {
                $idP      = $rowP['id'];
                $nombreP  = $rowP['nombre'];
                $precioP  = $rowP['precio'];
                $cantidadP= $_SESSION['carrito'][$idP];
                $subtotal = $precioP * $cantidadP;
                $total   += $subtotal;

                echo "<tr>";
                echo "<td>".htmlspecialchars($nombreP)."</td>";
                echo "<td>$cantidadP</td>";
                echo "<td>".number_format($precioP,2)." €</td>";
                echo "<td>".number_format($subtotal,2)." €</td>";
                echo "</tr>";
            }
            mysqli_free_result($resProd2);
        }

        echo "</tbody>";
        echo "</table>";
        echo "<h3>Total: ".number_format($total, 2)." €</h3>";
    }

    // Mostrar errores si hay
    if (count($errores) > 0) {
        echo "<div class='error'>";
        foreach ($errores as $err) {
            echo "<p>".htmlspecialchars($err)."</p>";
        }
        echo "</div>";
    }

    // Formulario
    ?>
    <h2>Datos del Cliente</h2>
    <form method="POST" action="">
        <p>Nombre Completo:</p>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" style="width:100%; padding:8px;">

        <p>Email:</p>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="width:100%; padding:8px;">

        <p>Teléfono:</p>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>" style="width:100%; padding:8px;">

        <p>Modo de Entrega:</p>
        <label><input type="radio" name="entrega" value="Recoger"   <?php if($entrega==="Recoger"){echo "checked";} ?>>Recoger</label><br>
        <label><input type="radio" name="entrega" value="Domicilio" <?php if($entrega==="Domicilio"){echo "checked";} ?>>Domicilio</label><br>
        <label><input type="radio" name="entrega" value="Local"     <?php if($entrega==="Local"){echo "checked";} ?>>Local</label><br><br>

        <button type="submit" class="boton">FINALIZAR</button>
    </form>
<?php
}
?>
</div>

<?php
// Incluimos el pie de página
include "pie.php";

// Cerramos la conexión
mysqli_close($conexion);
?>
