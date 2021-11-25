<?php

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('email');
        $v->Requerido('nombre');
        $v->Requerido('apellidos');
        $v->Requerido('password');
        $v->Requerido('password_confirm');
        $v->Requerido('nacimiento');
        if (count($v->errores) > 0) {
            echo $v->errores['email'] . "<br>";
            echo $v->errores['nombre'] . "<br>";
            echo $v->errores['apellidos'] . "<br>";
            echo $v->errores['password'] . "<br>";
            echo $v->errores['password_confirm'] . "<br>";
            echo $v->errores['nacimiento'] . "<br>";
            if ($_FILES["image"]["size"] == 0) {
                echo "Introduce una fotografía para continuar";
            }
        } else if ($_POST["password"] != $_POST["password_confirm"]) {
            echo "El campo de la contraseña y confirmar contraseña deben ser iguales";
        } else if ($_FILES["image"]["size"] == 0) {
            echo "Introduce una fotografía para continuar";
        } else {
            $email = $_POST['email'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $nacimiento = $_POST['nacimiento'];
            $rol = $_POST['rol'];
            $image = $_FILES['image']['tmp_name'];
            $imgContenido = file_get_contents($image);
            $imgContenido = base64_encode($imgContenido);
            $mismo_email = DB::existsUser($email);
            if (!$mismo_email) {
                $verifica = DB::insertUser($email, $nombre, $apellidos, $password, $nacimiento, $rol, $imgContenido);
                if ($verifica) {
                    echo("El usuario se dió de alta correctamente");
                } else {
                    echo("Hubo un fallo y no se pudó dar de alta");
                }
            }else{
                echo "El email introducido ya está registrado en la base de datos";
            }
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
                <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br>
            </label>
            <label for="nombre"> Nombre <br>
                <input type="text" name="nombre" value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"> <br>
            </label>
            <label for="apellidos"> Apellidos <br>
                <input type="text" name="apellidos" value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>"> <br>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"><br>
            </label>
            <label for="password_confirm"> Confirmar Contraseña <br>
                <input type="password" name="password_confirm" value="<?php echo isset($_POST['password_confirm']) ? htmlspecialchars($_POST['password_confirm']) : ''; ?>"><br>
            </label>
            <label for="nacimiento"> Fecha de Nacimiento <br>
                <input type="date" name="nacimiento" value="<?php echo isset($_POST['nacimiento']) ? htmlspecialchars($_POST['nacimiento']) : ''; ?>"><br>
            </label>

            <p>Selecciona el rol</p>

            <input type="radio" id="rol_01" name="rol" value="Usuario" checked>
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