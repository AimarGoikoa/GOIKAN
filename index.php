<?php


if (isset($_GET["page"])) {

  if ($_GET["page"] == "login.php") {

    include "./login.php";
  
  } elseif ($_GET["page"] == "config.php") {
  
    include "config.php";
  
  } elseif ($_GET["page"] == "pizzas.php") {
  
    include "pizzas.php";
  
  } elseif ($_GET["page"] == "nachos.php") {
  
    include "nachos.php";
  
  } elseif ($_GET["page"] == "resumen.php") {
  
    include "resumen.php";
  
  } elseif ($_GET["page"] == "resenas.php") {
  
    include "resenas.php";
  
  } elseif ($_GET["page"] == "contacto.php") {
  
    include "contacto.php";
  
  } elseif ($_GET["page"] == "alergenos") {
  
    echo "<a href=https://www.lapiazzapizzeria.es/wp-content/uploads/2023/09/carta-alergenos-es.pdf></a>";
  
  } 

} else {
  include "vista_index.php";
}



