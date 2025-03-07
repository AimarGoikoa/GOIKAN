<?php
require_once "database/database.php"; // sesión + conexión BD

if (isset($_GET["page"])) {

    if ($_GET["page"] === "login.php") {
        include "login.php";

    } elseif ($_GET["page"] === "config.php") {
        include "config.php";

    } elseif ($_GET["page"] === "pizzas.php") {
        // Consulta a WP para 'Pizzas'
        $sql = "SELECT p.ID, p.post_title, pm.meta_value AS image_id, img.guid AS image_url
                FROM wp_posts p
                JOIN wp_term_relationships tr ON p.ID = tr.object_id
                JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                JOIN wp_terms t ON tt.term_id = t.term_id
                LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
                LEFT JOIN wp_posts img ON pm.meta_value = img.ID
                WHERE p.post_type = 'product'
                  AND tt.taxonomy = 'product_cat'
                  AND t.name = 'Pizzas'";

        $resul = mysqli_query($conexion, $sql);
        $pizzas = array();
        if (!$resul) {
            $error = "Error en consulta: " . mysqli_error($conexion);
            // Podrías hacer: include "error.php"; exit;
            echo $error;
            exit;
        } else {
            while ($fila = mysqli_fetch_array($resul)) {
                $pizzas[] = $fila;
            }
            mysqli_free_result($resul);
        }
        // Mostrar la página pizzas.php
        include "pizzas.php";

    } elseif ($_GET["page"] === "nachos.php") {
        include "nachos.php";

    } elseif ($_GET["page"] === "resumen.php") {
        include "resumen.php";

    } elseif ($_GET["page"] === "resenas.php") {
        include "resenas.php";

    } elseif ($_GET["page"] === "contacto.php") {
        if (!isset($_POST['enviar']))
        {
            include "contacto.php";
            exit(); 
        }

        # VALIDACION
        $nombre =  trim($_POST['nombre']);
        $nombre = $_POST['nombre'];
        if (empty($nombre)){ 
        $errores['nombre'] = "No has introducido nombre";}
        else {$rnombre = $nombre;}

        $direccion = $_POST['direccion'];
        if (empty($direccion)){ 
        $errores['direccion'] = "No has introducido la dirección";}
        else {$rdireccion = $direccion;}

        $tlfn =  trim($_POST['tlfn']);
        $tlfn = $_POST['tlfn'];
        if (empty($tlfn) || !is_numeric($tlfn)){ 
        $errores['tlfn'] = "No has introducido el teléfono o no es numérico";}
        else {$rtlfn = $tlfn;}

        $email =  trim($_POST['email']);
        $email = $_POST['email'];
        if (empty($email)){ 
        $errores['email'] = "No has introducido el email";}
        else {$remail = $email;}

        $mensaje =  trim($_POST['mensaje']);
        $mensaje = $_POST['mensaje'];
        if (empty($tlfn)){ 
        $errores['mensaje'] = "No has introducido el mensaje a enviar";}
        else {$rmensaje = $mensaje;}

        # INSERCION
        if (empty($errores)) {
            $sql = "INSERT INTO contacto (nombre, direccion, tlfn, email, mensaje) 
        VALUES ('$nombre', '$direccion', '$tlfn', '$email', '$mensaje')";

        $result = mysqli_query($conexion, $sql);

        if ($result) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . mysqli_error($conexion);
        }

        }
        
        include "contacto.php";

    } elseif ($_GET["page"] === "logout.php") {
        include "logout.php";

    } else {
        // ?page=... no coincide
        echo "Página desconocida...";
    }

} else {
    // NO hay ?page => Página principal (vista_index.php)
    // Ejemplo: mostramos algunas pizzas en la portada

    $sql = "SELECT p.ID, p.post_title, pm.meta_value AS image_id, img.guid AS image_url
            FROM wp_posts p
            JOIN wp_term_relationships tr ON p.ID = tr.object_id
            JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            JOIN wp_terms t ON tt.term_id = t.term_id
            LEFT JOIN wp_postmeta pm ON p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id'
            LEFT JOIN wp_posts img ON pm.meta_value = img.ID
            WHERE p.post_type = 'product'
              AND tt.taxonomy = 'product_cat'
              AND t.name = 'Pizzas'
            LIMIT 6";

    $resul = mysqli_query($conexion, $sql);
    $pizzasIndex = array();
    if ($resul) {
        while ($fila = mysqli_fetch_array($resul)) {
            $pizzasIndex[] = $fila;
        }
        mysqli_free_result($resul);
    }
    // Ahora incluimos vista_index.php
    include "vista_index.php";
}
?>
