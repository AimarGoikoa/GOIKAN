<?php
include "cabecera.php"
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
        
        max-height: 350px;
       
        width: auto;
        height: auto;
    }

    .registro {
    display: block; 
    text-align: center; 
    margin-bottom: 20px; 
    font-size: 24px; 
    font-weight: bold; 
    color: #2e7d32; 
    }

    
</style>
<div class="container">
    <div class="image-section">
        <p><img src="./imagenes/localDenda.jpg" alt="imagen local">
            <img src="./imagenes/pizzaHorno3.jpg" alt="imagen pizza">
            <img src="./imagenes/local.jpg" alt="imagen pizza">
        </p>
    </div>
    <div class="form-section">
        <span class="registro"><strong>Nuevo Registro</strong> </span> <br />

        <form>
            <div class="form-group">
                <label for="full-name">Nombre Completo</label>
                <input type="text" id="full-name" name="full-name" placeholder="Nombre Completo">
            </div>
            <div class="form-group">
                <label for="nuevo_usuario">Nombre Usuario</label>
                <input type="text" id="nuevo_usuario" name="nuevo_usuario" placeholder="Nombre Usuario">
            </div>
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" id="dni" name="dni" placeholder="DNI">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" placeholder="Dirección">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" placeholder="Teléfono">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>
            <div class="form-group">
                <label for="confirm-password">Repetir Contraseña</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Repetir Contraseña">
            </div>
            <button type="submit" class="btn">Registrar</button>

    </div>
    </form>
    <div class="image-section">
        <p>
            <img src="./imagenes/pizzaLibre.jpg" alt="imagen pizza">
            <img src="./imagenes/pizzaHorno.jpg" alt="imagen pizza">
            <img src="./imagenes/local2.jpg" alt="imagen pizza">
        </p>
    </div>
</div>

<?php
include "pie.php"
?>