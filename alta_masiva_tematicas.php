<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
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
    <title>Alta Masiva de Usuarios</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_masiva_usuarios.css">
    <script src="https://kit.fontawesome.com/978435c791.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <h1> Alta Masiva de Tematicas</h1>
    </header>
    <main class="alta">
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="fichero">
                <input type='file' name='fichero'> <br>
            </label>
            <input type="submit" value="Enviar CSV" name="enviar">
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



function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename)) {
        return false;
    }

    $result = array();
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            $result[] = $row;
        }
        fclose($handle);
    }

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        if (isset($_FILES['fichero'])) {
            move_uploaded_file($_FILES['fichero']['tmp_name'], "csv/csv_thematic.csv");

            $all_data = csvToArray('csv/csv_thematic.csv', ",");
            DB::insertMassiveThematic($all_data);
            header("Location: full_listado_tematicas.php");
        }
    }
}
?>