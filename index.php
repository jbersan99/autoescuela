<?php

require_once "include/Sesion.php";
Sesion::iniciar();
if (Sesion::existe('usuario')) {
    header("Location: full_listado_examenes.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Autoescuela FTZ</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/978435c791.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <header>
        <img src="img/logo.png" alt="logo">
    </header>

    <main class="login">

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
    <?php

    error_reporting(E_ALL ^ E_NOTICE);

    include "include/DB.php";
    require_once "include/Login.php";
    require_once "include/Validator.php";
    require_once "include/User.php";

    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('email');
        $v->Requerido('password');
        if (count($v->errores) > 0) {
            echo '<span class="error">' . $v->errores['email'] . '</span> <br>';
            echo '<span class="error">' . $v->errores['password'] . '</span>';
        } else if (!$v->EmailValido($_POST['email'])) {
            echo '<span class="error"> Introduce un email que sea valido </span>';
        } else {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $logueado = Login::doLogin($email, $password, false);
            if ($logueado != "Las credenciales son invalidas") {
                $user = DB::getUser($email, $password);
                if ($user->getConfirmado() == "si") {
                    Login::UserisLogged();
                    Sesion::escribir('usuario', DB::getUser($email, $password));
                    if($user->getRol() == "Usuario"){
                        header("Location: full_listado_examenes_users.php");
                    }else{
                        header("Location: full_listado_examenes.php");
                    }
                    
                } else {
                    echo '<span class="error"> Tu usuario no ha sido confirmado aún, comprueba tu correo electronico </span>';
                }
            } else {
                echo '<span class="error"> Las credenciales son introducidas son invalidas </span>';
            }
        }
    }

    ?>
    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter <i class="fab fa-twitter"></i></a> <a href="facebook.com">Facebook <i class="fab fa-facebook-square"></i></a> <a href="instagram.com">Instagram <i class="fab fa-instagram-square"></i></a>
    </footer>
</body>

</html>