<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "include/User.php";

$id = $_GET['id'];
$user = DB::getUserbyId($id);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Usuario</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/editar_user.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>

<body>
    <header>
        <h1> Editar Usuario</h1>
    </header>
    <main class="alta">
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="email"> Email <br>
                <input type="email" name="email" readonly value="<?php echo $user->getEmail() ?>"><br>
            </label>
            <label for="nombre"> Nombre y Apellidos <br>
                <input type="text" name="nombre" value="<?php echo $user->getNombre() ?>"> <br>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password" value=""><br>
            </label>
            <label for="password_confirm"> Confirmar Contraseña <br>
                <input type="password" name="password_confirm" value=""><br>
            </label>
            <label for="nacimiento"> Fecha de Nacimiento <br>
                <input type="date" name="nacimiento" value="<?php echo $user->getNacimiento() ?>">
            </label>

            <section>Selecciona el rol:
                <input type="radio" id="rol_01" name="rol" value="Usuario" checked>
                <label for="rol_User">Usuario</label>

                <input type="radio" id="rol_01" name="rol" value="Profesor">
                <label for="rol_Prof">Profesor</label>
            </section>

            <label for="foto"> Selecciona la imagen de perfil: <br>
                <input type="file" class="form-control" id="image" name="image">
                <img id="imagenPrevisualizacion" width="175px"> <br>
                <script src="scripts/script.js"></script>
            </label>

            <input type="submit" value="Editar" name="enviar">
            <input type="submit" value="Eliminar Usuario" name="eliminar"><br>
            ¿Estas seguro de que quieres eliminar el usuario? <input type="checkbox" name="seguro"> <br> <br>


        </form>
    </main>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['enviar'])) {
            $v = new Validator();
            $v->Requerido('nombre');
            $v->Requerido('password');
            $v->Requerido('password_confirm');
            $v->Requerido('nacimiento');
            if (count($v->errores) > 0) {
                echo '<span class="error">' . $v->errores['nombre'] . '</span> <br>';
                echo '<span class="error">' . $v->errores['password'] . '</span> ';
                echo '<span class="error">' . $v->errores['password_confirm'] . '</span> <br>';
                echo '<span class="error">' . $v->errores['nacimiento'] . '</span> ';
                if ($_FILES["image"]["size"] == 0) {
                    echo '<span class="error">Introduce una imagen para continuar</span> <br>';
                }
            } else if ($_POST["password"] != $_POST["password_confirm"]) {
                echo '<span class="error">El campo de la contraseña y confirmar contraseña deben ser iguales</span> <br>';
            } else if ($_FILES["image"]["size"] == 0) {
                echo '<span class="error">Introduce una fotografía para continuar</span> <br>';
            } else if (!$v->FraseValida($_POST['nombre'])) {
                echo '<span class="error">Introduce un nombre que sea valido</span> <br>';
            } else {
                $nombre = $_POST['nombre'];
                $password = $_POST['password'];
                $password_confirm = $_POST['password_confirm'];
                $nacimiento = $_POST['nacimiento'];
                $rol = $_POST['rol'];
                $image = $_FILES['image']['tmp_name'];
                $imgContenido = file_get_contents($image);
                $imgContenido = base64_encode($imgContenido);
                $verifica = DB::updateUser($user->getId(), $nombre, $password, $nacimiento, $rol, $imgContenido);
                if ($verifica) {
                    header("Location: full_listado_usuarios.php");
                } else {
                    var_dump("Hubo un problema");
                }
            }
        } else if (isset($_POST['eliminar'])) {
            $seguro = $_POST['seguro'];

            if ($seguro == "on") {
                DB::deleteUser($user->getEmail());
                header("Location: full_listado_usuarios.php");
            } else {
                echo '<script>alert("Confirma que quieres borrar el usuario")</script>';
            }
        }
    }
    ?>

    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter</a> <a href="facebook.com">Facebook</a> <a href="instagram.com">Instagram</a>
    </footer>
</body>

</html>

