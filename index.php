<?php
include "cabecera.php";

echo print_r($_GET);

if ($_GET["page"] == "login.php") {
  
  include "./login.php";
}

?>

    <div class="galeria">

    <div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>

<div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>

<div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>

<div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>

<div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>

<div class="imagenes">
  <a target="_blank" href="pizzas.php">
    <img src="imagenes/images.jpg" alt="pizza1" width="350" height="200">
  </a>
  <div class="desc">DESCRIPCION DE LA OFERTA</div>
</div>


    </div>

<?php
include "pie.php"
?>