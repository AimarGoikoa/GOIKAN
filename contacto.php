<?php
include "cabecera.php";
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
        /* Cambia el color del texto al pasar el cursor */
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
        /* Ajusta el tamaño máximo del logo */
        max-height: 350px;
        /* Ajusta el tamaño máximo del logo */
        width: auto;
        height: auto;
    }
</style>

<div class="container">
    <div class="image-section">
        <p><img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno3.jpg" alt="imagen pizza">
        </p>
    </div>
    <div class="form-section">
        <h2>Contáctanos</h2>
        <div class="form-group">
            <label for="nombre">Nombre completo</label>
            <input type="text" name="nombre" placeholder="Nombre completo">
        </div><br />
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" placeholder="Dirección">
        </div><br />

        <div class="form-group">
            <label for="tlfn">Teléfono</label>
            <input type="text" name="tlfn" placeholder="Teléfono de contacto">
            
        </div><br />

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" placeholder="ejemplo@gmail.com">
        </div><br />

        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea name="mensaje" rows="10" cols="30"></textarea>
        </div><br />

        <input class="btn" type="submit" name="enviar" value="Enviar"><br /><br />
        <br />
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
?>