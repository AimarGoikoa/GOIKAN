<?php
// Si NO iniciaste sesión en otro archivo (p.ej. config.php), hazlo aquí:
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Goikan</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header class="cabecera">
    <!-- LOGO -->
    <div class="logo">
        <a href="index.php">
            <img src="imagenes/goikan_logo.png" alt="Goikan Logo">
        </a>
    </div>

    <!-- MENÚ PRINCIPAL -->
    <nav class="menu">
        <button><a href="index.php?page=pizzas.php">PIZZAS</a></button>
        <button><a href="index.php?page=nachos.php">NACHOS</a></button>
    </nav>

    <!-- OPCIONES (SEGÚN LOGIN) -->
    <div class="opciones">
        <?php if (isset($_SESSION["usuario_name"])): ?>
            <!-- Si está logueado, mostramos saludo y botón logout -->
            <p style="margin-right: 10px;">
                ¡Hola, <?php echo htmlspecialchars($_SESSION["usuario_name"]); ?>!
            </p>
            <button>
                <a href="logout.php">Cerrar Sesión</a>
            </button>
        <?php else: ?>
            <!-- Si NO está logueado, mostramos login/registro -->
            <button>
                <a href="index.php?page=login.php">INICIO DE SESIÓN/REGISTRO</a>
            </button>
            <button>
                <a href="index.php?page=config.php">CONFIGURACIÓN</a>
            </button>
        <?php endif; ?>
    </div>

    <!-- BOTÓN CARRITO (SIEMPRE VISIBLE) -->
    <div class="carrito">
        <button><a href="index.php?page=resumen.php">CARRITO</a></button>
    </div>
</header>
<main>
