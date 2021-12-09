<?php

error_reporting(E_ALL ^ E_NOTICE);

include "include/DB.php";
require_once "include/Sesion.php";
require_once "include/Tematica.php";
require_once "include/Validator.php";

$id = $_GET['id'];
$pregunta = DB::getQuestionbyId($id);

$tematicas = DB::getThematics();
$numero_respuestas = DB::getAllAnswers();
$numero_preguntas = DB::getAllQuestions();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar una Pregunta</title>
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <link rel="stylesheet" href="css/alta_pregunta.css">
</head>

<body>
    <header>
        <h1> Editar Pregunta </h1>
    </header>
    <main>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="tematica"> Tematica <br>
                <select name="tematica">
                    <?php

                    foreach ($tematicas as $tematica) {
                        echo '<option value="' . $tematica->getId() . '">' . $tematica->getTema() . '</option>';
                    }
                    ?>
                </select>
                <br>
            </label>
            <label for="enunciado"> Enunciado <br>
                <textarea name="enunciado" cols="30" rows="10" value="<?php echo $pregunta->getEnunciado_pregunta()?>"></textarea> <br>
            </label>
            <label for="opcion1"> Opcion 1 <br>
                <input type="text" name="respuesta_1" value="">
                <input type="radio" name="correcta" value="1"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 2 <br>
                <input type="text" name="respuesta_2" value="">
                <input type="radio" name="correcta" value="2"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 3 <br>
                <input type="text" name="respuesta_3" value="">
                <input type="radio" name="correcta" value="3"> Correcta<br>
            </label>
            <label for="opcion1"> Opcion 4 <br>
                <input type="text" name="respuesta_4" value="">
                <input type="radio" name="correcta" value="4"> Correcta<br>
            </label>
            <label for="foto"> Selecciona la imagen de la pregunta <br>
                <input type="file" class="form-control" id="image" name="image">
                <img id="imagenPrevisualizacion" width="150"> <br>
                <script src="scripts/script.js"></script>
            </label><br>
            <input type="submit" value="Enviar" name="enviar">

        </form>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['enviar'])) {
                $v = new Validator();
                $v->Requerido('enunciado');
                $v->Requerido('respuesta_1');
                $v->Requerido('respuesta_2');
                $v->Requerido('respuesta_3');
                $v->Requerido('respuesta_4');
                if (count($v->errores) > 0) {
                    echo '<br><span class="error">' . $v->errores['enunciado'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_1'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_2'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_3'] . '</span> ';
                    echo '<span class="error">' . $v->errores['respuesta_4'] . '</span> ';
                } else if ($_FILES["image"] != true) {
                    echo '<span class="error">Introduce una fotografía para continuar</span> ';
                } else if (!$v->FraseValida($_POST['enunciado'])) {
                    echo '<span class="error">Introduce un enunciado valido</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_1'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_2'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_3'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else if (!$v->FraseValida($_POST['respuesta_4'])) {
                    echo '<span class="error">Introduce una respuesta valida</span> ';
                } else {
                    $image = $_FILES['image']['tmp_name'];
                    $imgContenido = file_get_contents($image);
                    $imgContenido = base64_encode($imgContenido);
                    if(isset($_POST['correcta'])){
                        switch ($_POST['correcta']) {
                            case 1:
                                DB::insertAnswer($_POST['respuesta_1'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_2'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_3'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_4'], $pregunta->getId());
                                DB::updateQuestion($pregunta->getId(),$_POST['enunciado'], $numero_respuestas + 1, $imgContenido, $_POST["tematica"]);
                                break;
                            case 2:
                                DB::insertAnswer($_POST['respuesta_1'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_2'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_3'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_4'], $pregunta->getId());
                                DB::updateQuestion($pregunta->getId(),$_POST['enunciado'], $numero_respuestas + 2, $imgContenido, $_POST["tematica"]);
                                break;
                            case 3:
                                DB::insertAnswer($_POST['respuesta_1'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_2'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_3'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_4'], $pregunta->getId());
                                DB::updateQuestion($pregunta->getId(),$_POST['enunciado'], $numero_respuestas + 3, $imgContenido, $_POST["tematica"]);
                                break;
                            case 4:
                                DB::insertAnswer($_POST['respuesta_1'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_2'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_3'], $pregunta->getId());
                                DB::insertAnswer($_POST['respuesta_4'], $pregunta->getId());
                                DB::updateQuestion($pregunta->getId(),$_POST['enunciado'], $numero_respuestas + 4, $imgContenido, $_POST["tematica"]);
                                break;
                        }
                    }else{
                        echo '<span class="error">Elige una opcion correcta</span> ';
                    }
                    
                }
            }
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