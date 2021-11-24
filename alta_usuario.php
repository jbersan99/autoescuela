<?php

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

if (isset($_POST['enviar'])) {
    $v = new Validator();
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $nacimiento = $_POST['nacimiento'];
    if (empty($email) || empty($nombre) || empty($apellidos) || empty($password) || empty($password_confirm) || empty($nacimiento) || $rol == null) {
        $v->Requerido($email);
        $v->Requerido($nombre);
        $v->Requerido($password);
        $v->Requerido($password_confirm);
        $v->Requerido($nacimiento);
        $v->Requerido($rol);
    } else if ($password != $password_confirm) {
        $v->EsIgual($password, $password_confirm);
    } else if ($revisar == false) {
        var_dump("Introduce una fotografía para continuar");
    } else {
        $rol = $_POST['rol'];
        $revisar = getimagesize($_FILES["image"]["tmp_name"]);
        $image = $_FILES['image']['tmp_name'];
        $imgContenido = file_get_contents($image);
        $imgContenido = base64_encode($imgContenido);
        $verifica = DB::insertUser($email, $nombre, $apellidos, $password, $nacimiento, $rol, $imgContenido, 0);
        if ($verifica) {
            var_dump("El usuario se dió de alta correctamente");
        } else {
            var_dump("Hubo un fallo y no se pudó dar de alta");
        }
    }
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
        <form action="#" method="post" enctype="multipart/form-data">
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

            <label for="foto"> Selecciona la imagen de perfil <br>
                <input type="file" class="form-control" id="image" name="image" multiple> <br>
            </label>

            <input type="submit" value="Entrar" name="enviar">
        </form>
    </div>
</body>

</html>