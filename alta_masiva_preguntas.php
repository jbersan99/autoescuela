<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "include/Preguntas.php";

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
    <title>Alta Masiva de Preguntas</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_masiva_preguntas.css">
</head>

<body>
    <header>
        <h1> Alta Masiva de Preguntas</h1>
    </header>
    <main class="alta">
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="fichero">
                <input type='file' name='fichero'> <br>
            </label>
            <input type="submit" value="Entrar" name="enviar">
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
            move_uploaded_file($_FILES['fichero']['tmp_name'], "csv/csv_questions.csv");

            $all_data = csvToArray('csv/csv_questions.csv', ",");
            DB::insertMassiveQuestions($all_data);
        }
    }
}
?>