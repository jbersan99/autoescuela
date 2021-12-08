<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Contraseña</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/new_password.css">
</head>

<body>
    <header>
        <h1> Crear Nueva Contraseña </h1>
    </header>
    <main class="pass">
        <form action="#" method="post">
            <label for="new_pass"> Nueva Contraseña <br>
                <input type="password" name="new_pass_01"><br>
            </label>
            <label for="new_pass"> Nueva Contrasaeña de Nuevo <br>
                <input type="password" name="new_pass_02"><br>
            </label>
            <input type="submit" value="Crear contraseña" name="enviar">
        </form>
    </main>

    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter</a> <a href="facebook.com">Facebook</a> <a href="instagram.com">Instagram</a>
    </footer>
</body>

</html>

<?php

error_reporting(E_ALL ^ E_NOTICE);


include "include/DB.php";
require_once "include/Sesion.php";
require_once "entities/Tematica.php";
require_once "include/Validator.php";

$id_user = $_GET['id'];
var_dump($id_user);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('new_pass_01');
        $v->Requerido('new_pass_02');
        if (count($v->errores) > 0) {
            echo '<span class="error">' . $v->errores['new_pass_01'] . '</span> ';
            echo '<span class="error">' . $v->errores['new_pass_02'] . '</span> ';
        } else if ($_POST["new_pass_01"] != $_POST["new_pass_01"]) {
            echo '<span class="error">El campo de la contraseña y confirmar contraseña deben ser iguales</span> <br>';
        } else {
            $pass = $_POST['new_pass_01'];
            $confirmado = "si";
            DB::updatePass($pass, $id_user, $confirmado);
            header("Location: inicio.php");
        }
    }
}
?>