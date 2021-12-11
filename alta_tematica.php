<?php

require_once "include/User.php";
require_once "include/Sesion.php";

Sesion::iniciar();
if (!Sesion::existe('usuario')) {
    header("Location: index.php");
}else {
    $usuario = Sesion::leer('usuario');
    if ($usuario->getRol() == "Usuario") {
        header("Location: full_listado_examenes.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de una Tematica</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_tematica.css">
    <script src="https://kit.fontawesome.com/978435c791.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1> Alta Tematica </h1>
    </header>
    <main class="alta">
        <form action="#" method="post">
            <label for="tematica"> Tema a escoger <br>
                <input type="text" name="tema"><br>
            </label>
            <input type="submit" value="Introducir" name="enviar">
        </form>
    </main>

    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter <i class="fab fa-twitter"></i></a> <a href="facebook.com">Facebook <i class="fab fa-facebook-square"></i></a> <a href="instagram.com">Instagram <i class="fab fa-instagram-square"></i></a>
    </footer>
</body>

</html>

<?php

error_reporting(E_ALL ^ E_NOTICE);


include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Tematica.php";
require_once "include/Validator.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('tema');
        if (count($v->errores) > 0) {
            echo $v->errores['tema'] . "<br>";
        } else {
            $tematica = $_POST['tema'];
            $existe_tematica = DB::existsThematic($tematica);
            if ($existe_tematica == "No existe") {
                $verificar = DB::insertThematic($tematica);
                if ($verificar) {
                    header("Location: full_listado_tematicas.php");
                } else {
                    echo "Hubo un problema introduciendo la nueva tematica";
                }
            } else {
                echo "Esta tematica ya esta registrada en la base de datos";
            }
        }
    }
}
?>