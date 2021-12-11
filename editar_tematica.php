<?php

require_once "include/Sesion.php";
require_once "include/User.php";

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
    <title>Editar una Tematica</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/editar_tematica.css">
</head>

<body>
    <header>
        <h1> Editar Tematica </h1>
    </header>
    <main class="alta">
        <form action="#" method="post">
            <label for="tematica"> Tema a escoger <br>
                <input type="text" name="tema"><br>
            </label>
            <input type="submit" value="Introducir" name="enviar">
            <input type="submit" value="Eliminar Tematica" name="eliminar"><br>
            ¿Estas seguro de que quieres eliminar la Tematica? <input type="checkbox" name="seguro"> <br> <br>
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
require_once "include/Tematica.php";
require_once "include/Validator.php";

$id = $_GET['id'];

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
                $verificar = DB::updateThematic($id,$tematica);
                if ($verificar) {
                    header("Location: full_listado_tematicas.php");
                } else {
                    echo "Hubo un problema actualizando la nueva tematica";
                }
            } else {
                echo "Esta tematica ya esta registrada en la base de datos";
            }
        }
    } else if (isset($_POST['eliminar'])) {
        $seguro = $_POST['seguro'];
        if ($seguro == "on") {
            DB::deleteThematic($id);
            header("Location: full_listado_tematicas.php");
        } else {
            echo '<script>alert("Confirma que quieres borrar la tematica")</script>';
        }
    }
}
?>