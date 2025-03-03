<?php
session_start();     // Reanudamos la sesión
session_destroy();   // Destruimos los datos de la sesión
header("Location: index.php"); // Redirigimos a la página principal
exit;
