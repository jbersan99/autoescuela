<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Autoescuela FTZ</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/index_css.css">
</head>

<body>
    <header>
        <h1>Login Autoescuela</h1>
    </header>

    <main class="login">
        <img src="img/avatar.png" alt="logo">
        <form action="#" method="post">
            <label for="email"> Email <br>
                <input type="text" name="email"><br><br>                
                <span class="error_email"></span>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password"> <br>
            </label>
            <input type="submit" value="Entrar" name="enviar">
        </form>
        <section>
            <a>¿Has olvidado tu contraseña?</a>
        </section>
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
require_once "include/Login.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

if (isset($_POST['enviar'])) {
    $v = new Validator();
    $v->Requerido('email');
    $v->Requerido('password');
    if (count($v->errores) > 0) {
        echo '<span class="error">'.$v->errores['email'].'</span> <br>';
        echo '<span class="error">'.$v->errores['password'].'</span>';
    } else if (!$v->EmailValido($_POST['email'])) {
        echo '<span class="error"> Introduce un email que sea valido </span>';
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $logueado = Login::doLogin($email, $password, false);
        if ($logueado != "Las credenciales son invalidas") {
            Login::UserisLogged();
            Sesion::escribir('usuario', DB::getUser($email, $password));
            header("Location: inicio.php");
        } else {
            echo '<span class="error"> Las credenciales son introducidas son invalidas </span>';
        }
    }
}

?>