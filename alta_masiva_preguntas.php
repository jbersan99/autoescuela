<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Validator.php";
require_once "entities/Preguntas.php";

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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Masiva de Preguntas</title>
</head>

<body>
    <header>
        <h1> Alta Masiva de Preguntas</h1>
    </header>
    <div class="alta">
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="fichero">
                <input type='file' name='fichero'> <br>
            </label>
            <input type="submit" value="Entrar" name="enviar">
        </form>
    </div>
</body>

</html>