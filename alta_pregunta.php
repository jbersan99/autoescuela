<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "entities/Tematica.php";
require_once "include/Validator.php";

$tematicas = DB::getThematics();

$numero_respuestas = DB::getAllAnswers();
$numero_preguntas = DB::getAllQuestions();

if (isset($_POST['enviar'])) {
    switch ($_POST['correcta']) {
        case 1:
            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 1, "recurso", $_POST["tematica"]);
            break;
        case 2:
            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 2, "recurso",$_POST["tematica"]);
            break;
        case 3:
            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 3, "recurso",$_POST["tematica"]);
            break;
        case 4:
            DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
            DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
            DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 4, "recurso",$_POST["tematica"]);
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de una Pregunta</title>
</head>

<body>
    <header>
        <h1> Alta Pregunta </h1>
    </header>
    <form action="#" method="post">
        <label for="tematica"> Tematica <br>
            <select name="tematica">
                <?php
                foreach ($tematicas as $tematica) {
                    $linea = "";
                    $linea = $linea . '<option value="' . $tematica->getId() . '">' . $tematica->getTema() . '</option>';
                }
                echo $linea;
                ?>
            </select>
            <br>
        </label>
        <label for="enunciado"> Enunciado <br>
            <textarea name="enunciado" cols="30" rows="10" value="<?php echo isset($_POST['enunciado']) ? htmlspecialchars($_POST['enunciado']) : ''; ?>"></textarea> <br>
        </label>
        <label for="opcion1"> Opcion 1 <br>
            <input type="text" name="respuesta_1" value="<?php echo isset($_POST['respuesta_1']) ? htmlspecialchars($_POST['respuesta_1']) : ''; ?>">
            <input type="radio" name="correcta" value="1"> Correcta<br>
        </label>
        <label for="opcion1"> Opcion 2 <br>
            <input type="text" name="respuesta_2" value="<?php echo isset($_POST['respuesta_2']) ? htmlspecialchars($_POST['respuesta_2']) : ''; ?>">
            <input type="radio" name="correcta" value="2"> Correcta<br>
        </label>
        <label for="opcion1"> Opcion 3 <br>
            <input type="text" name="respuesta_3" value="<?php echo isset($_POST['respuesta_3']) ? htmlspecialchars($_POST['respuesta_3']) : ''; ?>">
            <input type="radio" name="correcta" value="3"> Correcta<br>
        </label>
        <label for="opcion1"> Opcion 4 <br>
            <input type="text" name="respuesta_4" value="<?php echo isset($_POST['respuesta_4']) ? htmlspecialchars($_POST['respuesta_4']) : ''; ?>">
            <input type="radio" name="correcta" value="4"> Correcta<br>
        </label>
        <input type="submit" value="Enviar" name="enviar">

    </form>
</body>

</html>