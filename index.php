<?php

include "include/DB.php";
require_once "include/Login.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/User.php";

    if(isset($_POST['enviar'])){
        var_dump("Enviar");
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(empty($email) || empty($password)){
            Validator::Requerido($email);
            Validator::Requerido($password);
        }else{
            Login::doLogin($email,$password,false);

            if(Login::UserisLogged()){
                Sesion::escribir('usuario', DB::getUser($email, $password));
                header("Location: inicio.php");
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
    <title>Login Autoescuela FTZ</title>
    <link rel="stylesheet" href="css/index_css.css">
</head>

<body>
    <header>
        <img src="img/avatar.png" alt="logo">
    </header>
    <div class="login">
        <form action="inicio.php" method="post">
            <label for="email"> Email <br>
                <input type="text" name="email"><br>
            </label>
            <label for="password"> Contraseña <br>
                <input type="password" name="password"> <br>
            </label>
            <input type="submit" value="Entrar" name="enviar">
        </form>
        <section>
            <a>¿Has olvidado tu contraseña?</a>
        </section>
    </div>
</body>
</html>