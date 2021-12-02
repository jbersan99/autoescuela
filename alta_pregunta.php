<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "entities/Tematica.php";
require_once "include/Validator.php";

$tematicas = DB::getThematics();

$numero_respuestas = DB::getAllAnswers();
$numero_preguntas = DB::getAllQuestions();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['enviar'])) {
        $v = new Validator();
        $v->Requerido('enunciado');
        $v->Requerido('respuesta_1');
        $v->Requerido('respuesta_2');
        $v->Requerido('respuesta_3');
        $v->Requerido('respuesta_4');
        if (count($v->errores) > 0) {
            echo $v->errores['enunciado'] . "<br>";
            echo $v->errores['respuesta_1'] . "<br>";
            echo $v->errores['respuesta_2'] . "<br>";
            echo $v->errores['respuesta_3'] . "<br>";
            echo $v->errores['respuesta_4'] . "<br>";
        } else if ($_FILES["image"] != true) {
            echo "Introduce una fotografía para continuar";
        } else if (!$v->FraseValida($_POST['enunciado'])) {
            echo "Introduce un enunciado valido";
        } else if (!$v->FraseValida($_POST['respuesta_1'])) {
            echo "Introduce una respuesta valida";
        } else if (!$v->FraseValida($_POST['respuesta_2'])) {
            echo "Introduce una respuesta valida";
        } else if (!$v->FraseValida($_POST['respuesta_3'])) {
            echo "Introduce una respuesta valida";
        } else if (!$v->FraseValida($_POST['respuesta_4'])) {
            echo "Introduce una respuesta valida";
        } else {
            $image = $_FILES['image']['tmp_name'];
            $imgContenido = file_get_contents($image);
            $imgContenido = base64_encode($imgContenido);
            switch ($_POST['correcta']) {
                case 1:
                    DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                    DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 1, $imgContenido, $_POST["tematica"]);
                    break;
                case 2:
                    DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                    DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 2, $imgContenido, $_POST["tematica"]);
                    break;
                case 3:
                    DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                    DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 3, $imgContenido, $_POST["tematica"]);
                    break;
                case 4:
                    DB::insertAnswer($_POST['respuesta_1'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_2'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_3'], $numero_preguntas + 1);
                    DB::insertAnswer($_POST['respuesta_4'], $numero_preguntas + 1);
                    DB::insertQuestion($_POST['enunciado'], $numero_respuestas + 4, $imgContenido, $_POST["tematica"]);
                    break;
            }
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
    <title>Alta de una Pregunta</title>
</head>

<body>
    <header>
        <h1> Alta Pregunta </h1>
    </header>
    <form action="#" method="post" enctype="multipart/form-data">
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
            <input type="radio" name="correcta" value="1" checked> Correcta<br>
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
        <label for="foto"> Selecciona la imagen de perfil <br>
            <input type="file" class="form-control" id="image" name="image"><br>
            <img id="imagenPrevisualizacion" width="150"> <br>
            <script src="scripts/script.js"></script>
        </label>
        <input type="submit" value="Enviar" name="enviar">

    </form>
</body>

</html>