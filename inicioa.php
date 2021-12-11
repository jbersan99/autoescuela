<?php
require_once "include/Sesion.php";
require_once "include/User.php";
Sesion::iniciar();
if (!Sesion::existe('usuario')) {
    header("Location: index.php");
} else {
    $usuario = Sesion::leer('usuario');
    if ($usuario->getRol() == "Usuario") {
        echo "<header> <h1> Este es el inicio para el usuario </h1> </header>";
        echo " <section id='menu'>";
        echo "<ul>";
        echo " <li><a href=''>Historico de Examenes</a></li>";
        echo " <li><a href=''>Realizar Examen</a></li>";
        echo " <li><a href=''>Examen Aleatorio</a></li>";
        echo "</ul>";
        echo "</section> ";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/inicio.css">
</head>

<body>
    <main>
        <?php 
        if ($usuario->getRol() == "Usuario") {
            include "full_listado_examenes.php";
        }else{
            include "full_listado_usuarios.php";
        }
        ?>
    </main>

    <footer>
        <hr>
        <p>Todos los derechos reservados</p>
        <p>Autoescuela Pepito</p>
        <a href="twitter.com">Twitter</a> <a href="facebook.com">Facebook</a> <a href="instagram.com">Instagram</a>
    </footer>
</body>

</html>