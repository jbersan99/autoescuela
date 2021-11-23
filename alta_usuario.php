<?php

include "include/DB.php";
require_once "include/Login.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

if (isset($_POST['enviar'])) {
    var_dump("Enviar");
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $password = $_POST['password'];
    $nacimiento = $_POST['nacimiento'];
    $rol = $_POST['rol'];
    $foto = $_POST['foto'];
    
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Usuario</title>
</head>

<body>
    <header>
        <h1> Alta Usuario</h1>
    </header>
    <div class="alta">
        <form action="inicio.php" method="post">
            <label for="email"> Email <br>
                <input type="email" name="email"><br>
            </label>
            <label for="nombre"> Nombre <br>
                <input type="text" name="nombre"> <br>
            </label>
            <label for="apellidos"> Apellidos <br>
                <input type="text" name="apellidos"> <br>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password"><br>
            </label>
            <label for="password_confirm"> Confirmar Contraseña <br>
                <input type="password" name="password_confirm"><br>
            </label>
            <label for="nacimiento"> Fecha de Nacimiento <br>
                <input type="date" name="nacimiento"><br>
            </label>

            <p>Selecciona el rol</p>

            <input type="radio" id="rol_01" name="rol" value="Usuario">
            <label for="rol_User">Usuario</label>

            <input type="radio" id="rol_01" name="rol" value="Profesor">
            <label for="rol_Prof">Profesor</label> <br>

            <input type="submit" value="Entrar" name="enviar">
        </form>
    </div>
</body>

</html>