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
        color: green;
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
            <img src="./imagenes/pizza.jpg" alt="imagen pizza">

        </p>
    </div>
    <div class="form-section">
        <h2>Editar Registro</h2>
        <div class="form-group">
            <label for="usuario">Nombre de Usuario</label>
            <input type="text" id="usuario" name="usuario" placeholder="Nombre de Usuario">
        </div>
        <div class="form-group">
            <label for="password">Contraseña Antigua</label>
            <input type="password" id="password" name="password" placeholder="Contraseña Antigua">
        </div>
        <div class="form-group">
            <label for="nueva">Nueva Contraseña</label>
            <input type="password" id="password" name="nueva" placeholder="Nueva Contraseña">
        </div>
        <div class="form-group">
            <label for="repetir">Repetir Contraseña</label>
            <input type="password" id="password" name="repetir" placeholder="Repetir Contraseña">
        </div>
        <div class="form-group">
            <label for="nombre">Nombre Completo </label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre Completo">
        </div>
        <div class="form-group">
        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" placeholder="DNI" /><br /><br />
        </div>
        <div class="form-group">
        <label for="direccion">Dirección</label>
        <input type="text" id="direccion" name="direccion" placeholder="Dirección" /><br /><br />
        </div>
        <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" /><br /><br />
        </div>
        <div class="form-group">
        <label for="tlf">Teléfono</label>
        <input type="telefono" id="telefono" name="telefono" placeholder="Teléfono" /><br /><br />
        </div>

    <input class="btn" type="submit" name="enviar" value="Guardar">
        <br />
        <br />
     
    </div>
    <div class="image-section">
        <p>

            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
            <img src="./imagenes/pizza.jpg" alt="imagen pizza">
            <img src="./imagenes/pizza.jpg" alt="imagen pizza">


        </p>
    </div>
</div>
<?php
include "pie.php";
?>